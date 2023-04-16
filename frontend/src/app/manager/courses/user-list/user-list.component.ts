import { Component, ElementRef, ViewChild } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';
import { CourseService } from 'src/app/services/course.service';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.css']
})
export class UserListComponent {
  @ViewChild('closebutton') closebutton!:any;
  @ViewChild('closeGemsButton') closeGemsButton!:any;
  
  id_course!: number;
  dataLoaded!: Promise<boolean>;
  user_data: any;
  user_list: any;
  all_users: any;
  editingUser!: number;

  form = new FormGroup({
    id_student: new FormControl(null, Validators.required)
  });

  formGems = new FormGroup({
    gems: new FormControl(null, Validators.compose([Validators.required, Validators.min(1)])),
    action: new FormControl(null, Validators.compose([Validators.required, Validators.pattern("res|sum|set")]))
  });
  
  constructor(private authService: AuthService, private userService: UserService,  private courseService: CourseService, private route: ActivatedRoute) { }

  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.id_course = params['id'];
    });

    this.userService.getUserDetails(String(localStorage.getItem('id'))).subscribe((response: any) => {
      if(response.status == 200 && response.data) {
        this.user_data = response.data;
        this.authService.checkPermissions(this.user_data.role);

        this.reloadUsers();
      } else {
        this.authService.logout();
      }
    });
  }

  reloadUsers() {
    this.courseService.getAllUsersByCourse(String(this.id_course)).subscribe((users: any) => {
      if(users.status == 200) {
        this.user_list = users.data;
        
        this.userService.getUsersByCollege(String(this.user_data.id_college)).subscribe((all_user: any) => {
          if(all_user.status == 200) {
            this.all_users = all_user.data;
            
            this.dataLoaded = Promise.resolve(true);
          }
        });
      }
    });
  }

  submitAddStudent() {
    if(this.form.invalid) {
      return;
    }

    this.userService.addCourse(String(this.id_course), String(this.form.get("id_student")?.value)).subscribe((result: any) => {
      if(result.status == 200) {
        this.reloadUsers();
        this.form.reset();
        this.closebutton.nativeElement.click();
      }
    });
  }

  submitRemoveStudent(id_user: string) {
    if(confirm("Are you sure duki gay?")) {
      this.userService.removeCourse(String(this.id_course), String(id_user)).subscribe((result: any) => {
        if(result.status == 200) {
          this.reloadUsers();
        }
      });
    }
  }

  submitAddGems() {
    if(this.formGems.invalid) {
      return;
    }

    this.userService.addGems(this.editingUser, Number(this.formGems.get("gems")?.value), String(this.formGems.get("action")?.value)).subscribe((result: any) => {
      if(result.status == 200) {
        this.reloadUsers();
        this.closeGemsButton.nativeElement.click();
      }
    });
  }
}
