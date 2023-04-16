import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit {
  dataLoaded!: Promise<boolean>;
  user_data: any;
  self_data: any;
  id_profile = "";
  selfProfile: boolean = false;

  constructor(private authService: AuthService, public userService: UserService,  private readonly route: ActivatedRoute, private readonly router: Router ) { }

  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.id_profile = params['id']; // (+) converts string 'id' to a number
    });

    this.selfProfile = this.id_profile == String(localStorage.getItem('id'));
    this.userService.getUserDetails(String(localStorage.getItem('id'))).subscribe((response: any) => {
      if(response.status == 200 && response.data) {
        this.self_data = response.data;
        
        this.userService.getUserDetails(String(this.id_profile)).subscribe((response: any) => {
          if(response.status == 200 && response.data) {
            this.user_data = response.data;
            this.user_data.skin = (this.user_data.skin != "{}" && this.user_data.skin != "" ? JSON.parse(this.user_data.skin) : JSON.parse('{"skin_base":"/assets/img/popers/poper1.png"}'));
            this.user_data.stats_base = (this.user_data.stats_base != "{}" && this.user_data.stats_base != "" ? JSON.parse(this.user_data.stats_base) : JSON.parse('{"health": "200", "strength": "50"}'))
    
            this.userService.getCourses(String(localStorage.getItem('id'))).subscribe((courses: any) => {
              if(courses.status == 200) {
                this.user_data.courses = courses.data;
        
                this.dataLoaded = Promise.resolve(true);
              } else {
                this.router.navigate(["/manager"])
              }
            });
          }
        });
      }
    });

  }
}
