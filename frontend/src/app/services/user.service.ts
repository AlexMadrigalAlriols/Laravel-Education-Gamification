import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { FrameworkService } from './framework.service';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  constructor(private frameworkService: FrameworkService) { }

  login(email: string, password: string) {
    return this.frameworkService.post('login', { email, password });
  }

  register(nick: string, name: string, last_name: string, email: string, college: string, password: string, password_confirmation: string) {
    return this.frameworkService.post('register', { nick, name, last_name, email, college, password, password_confirmation });
  }

  getUserDetails(id_user: string) {
    return this.frameworkService.post('users/get-user', { id_user });
  }

  getCourses(id_user: string) {
    return this.frameworkService.post('users/get-courses', { id_user });
  }

  getUsersByCollege(id_college: string) {
    return this.frameworkService.post('users/get-users-college', { id_college });
  }

  getTeachersByCollege(id_college: string) {
    return this.frameworkService.post('users/get-teachers-college', { id_college });
  }

  editUser(id_user: number, name: string, last_name: string, nick: string, email: string, role: string, birth_date: string, profile_img: string) {
    return this.frameworkService.post('users/edit-user', { id_user, name, last_name, nick, email, role, birth_date, profile_img });
  }

  addCourse(id_course: string, id_user: string) {
    return this.frameworkService.post('users/add-course', { id_user, id_course });
  }

  removeCourse(id_course: string, id_user: string) {
    return this.frameworkService.post('users/remove-course', { id_user, id_course });
  }

  addGems(id_user: number, pepas: number, action: string = "sum") {
    return this.frameworkService.post('users/modify-gems', { id_user, pepas, action });
  }

  joinCourseFromCode(id_user: number, code: string) {
    return this.frameworkService.post('users/join-course', { id_user, code });
  }
}
