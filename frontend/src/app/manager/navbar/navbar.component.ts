import { Component, Input } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';
import { FrameworkService } from 'src/app/services/framework.service';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent {
  @Input() user_details: any;

  constructor(private authService: AuthService, private router: Router) { }

  public logout() {
    this.authService.logout();
  }
}
