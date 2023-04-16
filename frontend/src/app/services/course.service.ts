import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { FrameworkService } from './framework.service';

@Injectable({
  providedIn: 'root'
})
export class CourseService {

  constructor(private frameworkService: FrameworkService, private router : Router) { }

  createCourse(course_name: string, id_teacher: string, id_college: string, img: string) {
    return this.frameworkService.post('course/create-course', { course_name, id_teacher, id_college, img });
  }

  saveCourse(id_course: number, course_name: string, id_teacher: string, id_college: string, img: string) {
    return this.frameworkService.post('course/save-course', { id_course, course_name, id_teacher, id_college, img });
  }

  getDetails(id_course: string) {
    return this.frameworkService.post('course/get-details', { id_course });
  }

  getAllUsersByCourse(id_course: string) {
    return this.frameworkService.post('course/get-users', { id_course });
  }

  getAllRequestsByCourse(id_course: string) {
    return this.frameworkService.post('course/get-requests', { id_course });
  }
  
  getRanking(id_course: string) {
    return this.frameworkService.post('course/get-ranking', { id_course });
  }

  resolveRequest(id_course: string, id_user: string, accepted: boolean) {
    return this.frameworkService.post('course/resolve-request', { id_course, id_user, accepted });
  }

  refreshCode(id_course: string) {
    return this.frameworkService.post('course/refresh-code', { id_course });
  }

  uploadFile(file: String) {
    return this.frameworkService.post('file', { file });
  }
}
