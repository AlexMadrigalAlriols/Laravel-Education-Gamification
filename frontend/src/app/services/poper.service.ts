import { Injectable } from '@angular/core';
import { FrameworkService } from './framework.service';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class PoperService {

  constructor(private frameworkService: FrameworkService) { }

  createPoper(id_user: number, poper_name: string, skin: string, stats: string, element: string) {
    return this.frameworkService.post('popers/create-poper', { id_user, poper_name, skin, stats, element });
  }
}
