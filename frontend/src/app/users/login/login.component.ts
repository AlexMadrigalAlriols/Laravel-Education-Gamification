import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {
  error = '';
  form = new FormGroup({
    email: new FormControl(null, Validators.required),
    password: new FormControl(null, Validators.required),
  });

  constructor(private authService: AuthService, private router: Router) { }

  onSubmit() {
    if (this.form.invalid) {
      return;
    }

    if(this.authService.login(String(this.form.get('email')?.value), String(this.form.get('password')?.value))) {
      this.router.navigate(["/manager"]);
    }
  }
}
