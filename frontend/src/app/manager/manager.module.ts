import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {ManagerRoutingModule } from "./manager-routing.module";
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { MainComponent } from './main/main.component';
import { HttpClientModule } from '@angular/common/http';
import { NavbarComponent } from './navbar/navbar.component';
import { LoaderComponent } from './loader/loader.component';
import { ProfileComponent } from './users/profile/profile.component';
import { EditUserComponent } from './users/edit-user/edit-user.component';
import { EditCourseComponent } from './courses/edit-course/edit-course.component';
import { CourseComponent } from './courses/course/course.component';
import { UserListComponent } from './courses/user-list/user-list.component';
import { RankingComponent } from './courses/ranking/ranking.component';
import { ShopComponent } from './courses/shop/shop.component';
import { NewPoperComponent } from './popers/new-poper/new-poper.component';
import { RequestsComponent } from './courses/requests/requests.component';
import { EditCollegeComponent } from './colleges/edit-college/edit-college.component';
import { TasksComponent } from './courses/tasks/tasks.component';
import { TaskViewComponent } from './courses/task-view/task-view.component';
import { EditTaskComponent } from './courses/edit-task/edit-task.component';
import { UserSubmitsListComponent } from './user-submits-list/user-submits-list.component';


@NgModule({
  declarations: [
    MainComponent,
    NavbarComponent,
    LoaderComponent,
    ProfileComponent,
    EditUserComponent,
    EditCourseComponent,
    CourseComponent,
    UserListComponent,
    RankingComponent,
    ShopComponent,
    NewPoperComponent,
    RequestsComponent,
    EditCollegeComponent,
    TasksComponent,
    TaskViewComponent,
    EditTaskComponent,
    UserSubmitsListComponent
  ],
  imports: [
    CommonModule,
    ReactiveFormsModule,
    FormsModule,
    ManagerRoutingModule,
    HttpClientModule
  ]
})
export class ManagerModule {
  
}
