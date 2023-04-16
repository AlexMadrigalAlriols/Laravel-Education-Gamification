import { Injectable } from '@angular/core';
import { FrameworkService } from './framework.service';

@Injectable({
  providedIn: 'root'
})
export class CollegeService {

  constructor(private frameworkService: FrameworkService) { }

  getCollegeDetails(id_college: string) {
    return this.frameworkService.post('college/get-college', { id_college });
  }

  saveCollege(id_college: string, college_name: string, logo: string) {
    return this.frameworkService.post('college/save-college', { id_college, college_name, logo });
  }
}
