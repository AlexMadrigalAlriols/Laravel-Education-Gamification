import { Component, ViewChild } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';
import { CourseService } from 'src/app/services/course.service';
import { TaskService } from 'src/app/services/task.service';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-edit-task',
  templateUrl: './edit-task.component.html',
  styleUrls: ['./edit-task.component.css']
})
export class EditTaskComponent {
  @ViewChild('closeCategoryModal') closeCategoryModal!:any;

  alreadySubmit: boolean = false;
  dataLoaded!: Promise<boolean>;
  user_data: any;
  id_course?: number;
  id_task?: number;
  course_data: any;
  task_data: any;
  categories: any = [];
  task_types = ["Task", "Forum", "Exam", "File", "Link", "Page"];

  form = new FormGroup({
    title: new FormControl(null, Validators.compose([Validators.minLength(2), Validators.required])),
    description: new FormControl(null),
    id_category: new FormControl(null, Validators.required),
    type: new FormControl(null, Validators.compose([Validators.required, Validators.pattern(this.task_types.join('|').toLowerCase())])),
    limit_date: new FormControl(null),
    file_rubrica: new FormControl(null),
    contents: new FormControl(null),
    percentage: new FormControl(null),
    max_mark: new FormControl(null),
  });

  categoryForm = new FormGroup({
    title: new FormControl(null, Validators.required)
  })

  constructor(private authService: AuthService, private userService: UserService, private route: ActivatedRoute,  private router: Router, private courseService: CourseService, private tasksService: TaskService) { }

  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.id_course = params['id']; // (+) converts string 'id' to a number
      this.id_task = params['id_task']; // (+) converts string 'id' to a number
    });

    this.userService.getUserDetails(String(localStorage.getItem('id'))).subscribe((response: any) => {
      if(response.status == 200 && response.data) {
        this.user_data = response.data;
        
        this.authService.checkPermissions(this.user_data.role, ["college_manager", "teacher"]);

        this.courseService.getDetails(String(this.id_course)).subscribe((courses: any) => {
          if(courses.status == 200) {
            this.course_data = courses.data;

            if(this.id_task != 0) {
              this.tasksService.getTaskDetails(Number(this.id_task)).subscribe((tasks: any) => {
                if(tasks.status == 200) {
                  this.task_data = tasks.data;

                  this.reloadCateogries();
                }
              });
            } else {
              this.task_data = {title: "", description: "", id_category: 0, file_rubrica: "", img: "", id_teacher: " "}
              
              this.reloadCateogries();
            }

          }
        });

      } else {
        this.authService.logout();
      }
    });
  }

  onSubmit() {
    if(this.form.invalid) {
      return;
    }

    if(this.id_task != 0) {
      this.tasksService.editTask(Number(this.id_task), Number(this.form.get("id_category")?.value), String(this.form.get("type")?.value), String(this.form.get("title")?.value), String(this.form.get("description")?.value), String(this.form.get("limit_date")?.value), String(this.form.get("percentage")?.value), String(this.form.get("max_mark")?.value)).subscribe((result: any) => {
        if(result.status == 200) {
          this.router.navigate(["/manager/course/"+this.id_course+"/tasks"]);
        }
  
        this.dataLoaded = Promise.resolve(true);
      });
    } else {
      this.tasksService.newTask(Number(this.form.get("id_category")?.value), String(this.form.get("type")?.value), String(this.form.get("title")?.value), String(this.form.get("description")?.value), String(this.form.get("limit_date")?.value), String(this.form.get("percentage")?.value), String(this.form.get("max_mark")?.value)).subscribe((result: any) => {
        if(result.status == 200) {
          this.router.navigate(["/manager/course/"+this.id_course+"/tasks"]);
        }
  
        this.dataLoaded = Promise.resolve(true);
      });
    }
  }

  reloadCateogries() {
    this.tasksService.getCategories(Number(this.id_course)).subscribe((category: any) => {
      if(category.status == 200) {
        this.categories = category.data;
      }

      this.dataLoaded = Promise.resolve(true);
    });
  }

  onSubmitCategory() {
    if(this.categoryForm.invalid) {
      return;
    }

    this.tasksService.createCategory(Number(this.id_course), String(this.categoryForm.get("title")?.value)).subscribe((result: any) => {
      if(result.status == 200) {
        this.reloadCateogries();
        this.closeCategoryModal.nativeElement.click();
      }

      this.dataLoaded = Promise.resolve(true);
    });
  }
}