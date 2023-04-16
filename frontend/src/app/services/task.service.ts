import { Injectable } from '@angular/core';
import { FrameworkService } from './framework.service';

@Injectable({
  providedIn: 'root'
})
export class TaskService {

  constructor(private frameworkService: FrameworkService) { }

  getTasksList(id_course: number) {
    return this.frameworkService.post('tasks/get-tasks-list', { id_course });
  }

  getTaskDetails(id_task: number) {
    return this.frameworkService.post('tasks/get-task', { id_task });
  }

  removeTask(id_task: number) {
    return this.frameworkService.post('tasks/delete-task', { id_task });
  }

  getCategories(id_course: number) {
    return this.frameworkService.post('tasks/get-categories', { id_course });
  }

  newCategory(id_category: number, type: string, title: string, description: string, limit_date: string, percentage: string, max_mark: string) {
    return this.frameworkService.post('tasks/new-category', { id_category, type, title, description, limit_date, percentage, max_mark });
  }

  newTask(id_category: number, type: string, title: string, description: string, limit_date: string, percentage: string, max_mark: string) {
    return this.frameworkService.post('tasks/new-task', { id_category, type, title, description, limit_date, percentage, max_mark });
  }

  editTask(id_task: number, id_category: number, type: string, title: string, description: string, limit_date: string, percentage: string, max_mark: string) {
    return this.frameworkService.post('tasks/edit-task', { id_task, id_category, type, title, description, limit_date, percentage, max_mark });
  }

  createCategory(id_course: number, title: string) {
    return this.frameworkService.post('tasks/new-category', { title, id_course });
  }

  uploadTask(id_tasks: number, id_user: number, submit: string) {
    return this.frameworkService.post('tasks/new-upload', { id_tasks, id_user, submit });
  }

  getAllSubmitsByCourse(id_course: number) {
    return this.frameworkService.post('tasks/get-submits', { id_course });
  }

  setMark(id_users_submits: number, mark: number) {
    return this.frameworkService.post('tasks/set-mark', { id_users_submits, mark });
  }
}
