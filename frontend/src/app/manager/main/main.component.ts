import { Component, OnInit, ViewChild } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';
import { CollegeService } from 'src/app/services/college.service';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-main',
  templateUrl: './main.component.html',
  styleUrls: ['./main.component.css']
})
export class MainComponent implements OnInit {
  @ViewChild('closebutton') closebutton!:any;
  dataLoaded!: Promise<boolean>;
  user_data: any;
  courses: any;
  hasPoper: boolean = false;

  form = new FormGroup({
    code: new FormControl(null, Validators.required)
  });

  constructor(private authService: AuthService, private userService: UserService, private router: Router) { }

  ngOnInit(): void {
    this.userService.getUserDetails(String(localStorage.getItem('id'))).subscribe((response: any) => {
      if(response.status == 200 && response.data) {
        this.user_data = response.data;

        if(this.user_data.id_poper) {
          this.hasPoper = true;
          this.reloadCourses();
        } else {
          this.hasPoper = false;
          this.dataLoaded = Promise.resolve(true);
        }
      } else {
        this.authService.logout();
      }
    });
  }

  reloadCourses() {
    this.userService.getCourses(String(localStorage.getItem('id'))).subscribe((courses: any) => {
      if(courses.status == 200) {
        this.user_data.courses = courses.data;
        this.dataLoaded = Promise.resolve(true);
      } else {
        this.authService.logout();
      }
    });
  }

  joinCourse() {
    if(this.form.invalid) {
      return;
    }

    this.userService.joinCourseFromCode(Number(localStorage.getItem('id')), String(this.form.get('code')?.value)).subscribe((courses: any) => {
      if(courses.status == 200) {
        this.reloadCourses();
        this.closebutton.nativeElement.click();
      }
    });
  }
}
