import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';
import { FrameworkService } from 'src/app/services/framework.service';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-edit-user',
  templateUrl: './edit-user.component.html',
  styleUrls: ['./edit-user.component.css']
})
export class EditUserComponent implements OnInit {
  dataLoaded!: Promise<boolean>;
  user_data: any;
  editing_data: any;
  files: any;
  id_profile!: number;

  form = new FormGroup({
    nick: new FormControl(null, Validators.compose([Validators.minLength(6), Validators.required])),
    name: new FormControl(null, Validators.compose([Validators.minLength(4), Validators.required])),
    last_name: new FormControl(null, Validators.required),
    email: new FormControl(null, Validators.compose([Validators.email, Validators.required])),
    role: new FormControl(null, Validators.compose([Validators.required, Validators.pattern("student|college_manager|teacher")])),
    birth_date: new FormControl(null)
  });

  constructor(private authService: AuthService, public userService: UserService,  private readonly route: ActivatedRoute, private readonly router: Router, private frameworkService: FrameworkService ) { }

  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.id_profile = params['id']; // (+) converts string 'id' to a number
    });

    this.userService.getUserDetails(String(localStorage.getItem('id'))).subscribe((response: any) => {
      if(response.status == 200 && response.data) {
        this.user_data = response.data;
        this.userService.getUserDetails(String(this.id_profile)).subscribe((response: any) => {
          if(response.status == 200 && response.data) {
            this.editing_data = response.data;
            
            this.authService.checkPermissions(this.user_data.role, ["student", "teacher", "college_manager"], "/manager", this.id_profile, Number(localStorage.getItem('id')));
            this.dataLoaded = Promise.resolve(true);
          } else {
            this.router.navigate(["/manager"]);
          }
        });
      } else {
        this.authService.logout();
      }
    });
  }

  uploadImage(event: any){
    this.files = event.target.files[0];
  }

  onSubmit() {
    if (this.form.invalid) {
      return;
    }

    const formData = new FormData();
    formData.append("img", this.files, this.files.name);

    this.frameworkService.upload_file(formData).subscribe((result: any) => {
      this.userService.editUser(this.id_profile, String(this.form.get('name')?.value), String(this.form.get('last_name')?.value), String(this.form.get('nick')?.value), String(this.form.get('email')?.value), String(this.form.get('role')?.value), String(this.form.get('birth_date')?.value), result.data).subscribe((response: any) => {
        if(response.status == 200) {
          this.router.navigate(["/manager/user/"+this.editing_data.id_user]);
        }
      });
    });
  }
}
