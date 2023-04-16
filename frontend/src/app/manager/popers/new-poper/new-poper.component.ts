import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { PoperService } from 'src/app/services/poper.service';

@Component({
  selector: 'app-new-poper',
  templateUrl: './new-poper.component.html',
  styleUrls: ['./new-poper.component.css']
})
export class NewPoperComponent implements OnInit {
  popers = [
    {name: "Juan", background: "/assets/img/backgrounds/2_background.jpg", img: "/assets/img/popers/poper1.png", element: "psyco"},
    {name: "Chemita", background: "/assets/img/backgrounds/1_background.jpg", img: "/assets/img/popers/poper2.png", element: "wild"},
    {name: "Rodrigo", background: "/assets/img/backgrounds/3_background.jpg", img: "/assets/img/popers/poper3.png", element: "water"}
  ];

  form = new FormGroup({
    poper_name: new FormControl<string | null>(null, Validators.compose([Validators.minLength(2), Validators.required])),
    vitality: new FormControl<number | null>(null, Validators.required),
    velocity: new FormControl<number | null>(null, Validators.required),
    epower: new FormControl<number | null>(null, Validators.required)
  });

  actual_poper = {name: "Test", background: "/assets/img/backgrounds/1_background.jpg", img: "/assets/img/popers/poper1.png", element: "Wild"};
  actual_poper_id = 0;
  points = 8;

  constructor(private poperService: PoperService, private readonly router: Router ) { }
  ngOnInit(): void {
    this.actual_poper_id = Math.floor(Math.random() * this.popers.length);
    this.generatePoper();
  }

  generatePoper() {
    this.actual_poper = this.popers[this.actual_poper_id];

    this.form.setValue({
      poper_name: this.actual_poper.name,
      vitality: 0, 
      velocity: 0,
      epower: 0
    });
  }

  checkPoints() {
    var sumTotal = Number(this.form.get("vitality")?.value) + Number(this.form.get("velocity")?.value) + Number(this.form.get("epower")?.value);
    
    this.points = 8 - sumTotal;
  }

  next() {
    this.actual_poper_id++;

    if(this.actual_poper_id > this.popers.length) {
      this.actual_poper_id = this.popers.length - 1;
    }

    this.generatePoper();
  }

  prev() {
    this.actual_poper_id--;

    if(this.actual_poper_id <= 0) {
      this.actual_poper_id = 0;
    }

    this.generatePoper();
  }

  onSubmit() {
    if (this.form.invalid || this.points < 0) {
      return;
    }
    var skin = JSON.stringify({skin_base: this.actual_poper.img});
    var stats = JSON.stringify({vitality: String(this.form.get('vitality')?.value), velocity: String(this.form.get('velocity')?.value), epower: String(this.form.get('epower')?.value)})

    this.poperService.createPoper(Number(localStorage.getItem('id')), String(this.form.get('poper_name')?.value), skin, stats, this.actual_poper.element.toLowerCase()).subscribe((response: any) => {
      if(response.status == 200) {
        console.log(response);
        this.router.navigate(["/manager"]);
      }
    });
  }
}
