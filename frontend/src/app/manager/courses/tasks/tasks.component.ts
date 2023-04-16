import { Component, ViewChild } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';
import { CourseService } from 'src/app/services/course.service';
import { TaskService } from 'src/app/services/task.service';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-tasks',
  templateUrl: './tasks.component.html',
  styleUrls: ['./tasks.component.css']
})
export class TasksComponent {
  @ViewChild('closeCategoryModal') closeCategoryModal!:any;
  @ViewChild('openModal') openModal!:any;

  alreadySubmit: boolean = false;
  dataLoaded!: Promise<boolean>;
  user_data: any;
  id_course?: number;
  course_data: any;
  tasks_list: any;
  submits_list: any;
  id_users_submits: any;

  markForm = new FormGroup({
    mark: new FormControl(null, Validators.required)
  });

  constructor(private authService: AuthService, private userService: UserService, private route: ActivatedRoute,  private router: Router, private courseService: CourseService, private tasksService: TaskService) { }

ngOnInit(): void {
  this.route.params.subscribe(params => {
    this.id_course = params['id']; // (+) converts string 'id' to a number
  });


  this.userService.getUserDetails(String(localStorage.getItem('id'))).subscribe((response: any) => {
    if(response.status == 200 && response.data) {
      this.user_data = response.data;
      
      this.authService.checkPermissions(this.user_data.role, ["student", "college_manager", "teacher"]);

      this.courseService.getDetails(String(this.id_course)).subscribe((courses: any) => {
        if(courses.status == 200) {
          this.course_data = courses.data;
          
          this.reloadTasks();
          this.reloadUploads();
          this.dataLoaded = Promise.resolve(true);
        }
      });

    } else {
      this.authService.logout();
    }
  });
}

reloadTasks() {
  this.tasksService.getTasksList(Number(this.id_course)).subscribe((tasks: any) => {
    if(tasks.status == 200) {
      this.tasks_list = tasks.data;

      if(this.tasks_list.tasks) {
        this.tasks_list.tasks = JSON.parse(this.tasks_list.tasks);
      }
    }
  });
  this.alreadySubmit = false;
}

reloadUploads() {
  this.tasksService.getAllSubmitsByCourse(Number(this.id_course)).subscribe((tasks: any) => {
    if(tasks.status == 200) {
      this.submits_list = tasks.data;
    }
  });
  
  this.alreadySubmit = false;
}

deleteTask(id_task: number) {
  if(confirm("Are you sure little dog?")){
    this.alreadySubmit = true;
    this.tasksService.removeTask(id_task).subscribe((tasks: any) => {
      if(tasks.status == 200) {
        this.reloadTasks();
      }
    });
  }
}

openMarkModal(id_subm: number) {
  this.openModal.nativeElement.click();
  this.id_users_submits = id_subm;
}

onsubmitMark() {
  this.tasksService.setMark(Number(this.id_users_submits),  Number(this.markForm.get("mark")?.value)).subscribe((tasks: any) => {
    if(tasks.status == 200) {
      this.closeCategoryModal.nativeElement.click();
      this.reloadUploads();
    }
  });

  this.alreadySubmit = false;
}

}