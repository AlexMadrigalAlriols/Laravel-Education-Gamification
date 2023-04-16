import { Component } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { Post } from 'src/app/post.model';
import { AuthService } from 'src/app/services/auth.service';
import { CourseService } from 'src/app/services/course.service';
import { FrameworkService } from 'src/app/services/framework.service';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-edit-course',
  templateUrl: './edit-course.component.html',
  styleUrls: ['./edit-course.component.css']
})
export class EditCourseComponent {
  alreadySubmit: boolean = false;
  id_course!: number;
  dataLoaded!: Promise<boolean>;
  user_data: any;
  course_data: any;
  teachers: any;
  files: any;
  form = new FormGroup({
    course_name: new FormControl(null, Validators.compose([Validators.minLength(3), Validators.required])),
    id_teacher: new FormControl(null, Validators.required),
    img: new FormControl(null)
  });

  constructor(private authService: AuthService, private router: Router, private courseService: CourseService, private route: ActivatedRoute, private frameworkService: FrameworkService,  private userService: UserService) { }

  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.id_course = params['id']; // (+) converts string 'id' to a number
    });

    this.userService.getUserDetails(String(localStorage.getItem('id'))).subscribe((response: any) => {
      if(response.status == 200 && response.data) {
        this.user_data = response.data;
        
        this.authService.checkPermissions(this.user_data.role);
        this.userService.getTeachersByCollege(String(this.user_data.id_college)).subscribe((result: any) => {
          if(result.status == 200) {
            this.teachers = result.data;
            if(this.id_course != 0) {
              this.courseService.getDetails(String(this.id_course)).subscribe((courses: any) => {
                if(courses.status == 200) {
                  this.course_data = courses.data;

                  this.dataLoaded = Promise.resolve(true);
                }
              });

            } else {
              this.course_data = {course_name: "", img: "", id_teacher: " "}
              this.dataLoaded = Promise.resolve(true);
            }
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
    if(this.form.invalid) {
      this.alreadySubmit = true;
      return;
    }
    
    const formData = new FormData();
    if(this.files != null) {
      formData.append("img", this.files, this.files.name);
    }

    this.alreadySubmit = true;
    if(this.id_course != 0) {
      this.frameworkService.upload_file(formData).subscribe((result: any) => {
        this.courseService.saveCourse(this.id_course, String(this.form.get('course_name')?.value), String(this.form.get('id_teacher')?.value), this.user_data.id_college, String(result.data)).subscribe((courses: any) => {
          if(courses.status == 200) {
            this.router.navigate(["/manager"]);
          }
          
          this.alreadySubmit = false;
        });
      });
    } else {
      this.courseService.createCourse(String(this.form.get('course_name')?.value), String(this.form.get('id_teacher')?.value), this.user_data.id_college, String(this.form.get('img')?.value)).subscribe((courses: any) => {
        if(courses.status == 200 && this.files != null) {
          this.courseService.uploadFile(String(this.form.get("img")?.value)).subscribe((result: any) => {
            this.router.navigate(["/manager"]);
          });
        }
        this.alreadySubmit = false;
      });
    }
  }
}
