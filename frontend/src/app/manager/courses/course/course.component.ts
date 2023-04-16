import { Component, ViewChild } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';
import { CourseService } from 'src/app/services/course.service';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-course',
  templateUrl: './course.component.html',
  styleUrls: ['./course.component.css']
})
export class CourseComponent {
  id_course!: number;
  dataLoaded!: Promise<boolean>;
  user_data: any;
  course_data: any;

  code: string = "";
  refreshDisabled = false;

  constructor(private authService: AuthService, private userService: UserService,  private courseService: CourseService, private route: ActivatedRoute, private router: Router) { }

  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.id_course = params['id']; // (+) converts string 'id' to a number
    });

    this.userService.getUserDetails(String(localStorage.getItem('id'))).subscribe((response: any) => {
      if(response.status == 200 && response.data) {
        this.user_data = response.data;

        this.courseService.getDetails(String(this.id_course)).subscribe((courses: any) => {
          if(courses.status == 200) {
            this.course_data = courses.data;
            this.course_data.requests = JSON.parse(this.course_data.requests);
            this.code = this.course_data.code;
            
            this.dataLoaded = Promise.resolve(true);
          }
        });
      } else {
        this.authService.logout();
      }
    });
  }

  refreshCode() {
    this.refreshDisabled = true;
    this.courseService.refreshCode(String(this.id_course)).subscribe((result: any) => {
      if(result.status == 200) {
        this.code = result.new_code;
        this.refreshDisabled = false;
      }
    });
  }
}
