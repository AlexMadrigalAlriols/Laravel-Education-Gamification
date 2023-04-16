import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import { EditCollegeComponent } from './colleges/edit-college/edit-college.component';
import { CourseComponent } from './courses/course/course.component';
import { EditCourseComponent } from './courses/edit-course/edit-course.component';
import { EditTaskComponent } from './courses/edit-task/edit-task.component';
import { RankingComponent } from './courses/ranking/ranking.component';
import { RequestsComponent } from './courses/requests/requests.component';
import { ShopComponent } from './courses/shop/shop.component';
import { TaskViewComponent } from './courses/task-view/task-view.component';
import { TasksComponent } from './courses/tasks/tasks.component';
import { UserListComponent } from './courses/user-list/user-list.component';
import { MainComponent } from './main/main.component';
import { UserSubmitsListComponent } from './user-submits-list/user-submits-list.component';
import { EditUserComponent } from './users/edit-user/edit-user.component';
import { ProfileComponent } from './users/profile/profile.component';


const routes: Routes = [
  {path: '', component: MainComponent},

  //Users
  {path: 'user/:id', component: ProfileComponent},
  {path: 'user/edit/:id', component: EditUserComponent},

  // Courses
  {path: 'course/edit/:id', component: EditCourseComponent},
  {path: 'course/:id', component: CourseComponent},
  {path: 'course/:id/users', component: UserListComponent},
  {path: 'course/:id/ranking', component: RankingComponent},
  {path: 'course/:id/requests', component: RequestsComponent},
  {path: 'course/:id/shop', component: ShopComponent},

  // Tasks
  {path: 'course/:id/tasks', component: TasksComponent},
  {path: 'course/:id/tasks/:id_task', component: TaskViewComponent},
  {path: 'course/:id/edit-task/:id_task', component: EditTaskComponent},
  {path: 'course/:id/user-submits/:id_task', component: UserSubmitsListComponent},

  //College
  {path: 'college/:id/edit', component: EditCollegeComponent},
]; 

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class ManagerRoutingModule {

}
