
import { Component, ViewChild } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';
import { CourseService } from 'src/app/services/course.service';
import { UserService } from 'src/app/services/user.service';


@Component({
  selector: 'app-requests',
  templateUrl: './requests.component.html',
  styleUrls: ['./requests.component.css']
})
export class RequestsComponent {
  
  id_course!: number;
  dataLoaded!: Promise<boolean>;
  user_data: any;
  user_list: any;
  all_users: any;
  editingUser!: number;

  constructor(private authService: AuthService, private userService: UserService,  private courseService: CourseService, private route: ActivatedRoute) { }

  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.id_course = params['id']; // (+) converts string 'id' to a number
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
    this.courseService.getAllRequestsByCourse(String(this.id_course)).subscribe((users: any) => {
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

  submitRequest(id_user: string, accepted: boolean) {
    this.courseService.resolveRequest(String(this.id_course), id_user, accepted).subscribe((result: any) => {
      console.log(result);
      if(result.status == 200) {
        this.reloadUsers();
      }
    });
  }
}
