import { Component } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';
import { CourseService } from 'src/app/services/course.service';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-ranking',
  templateUrl: './ranking.component.html',
  styleUrls: ['./ranking.component.css']
})
export class RankingComponent {
  dataLoaded!: Promise<boolean>;
  ranking_list: boolean = true;
  user_data: any;
  ranking: any;
  id_course!: number;

  constructor(private authService: AuthService, private userService: UserService, private route: ActivatedRoute, private courseService: CourseService) { }

  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.id_course = params['id']; // (+) converts string 'id' to a number
    });

    this.userService.getUserDetails(String(localStorage.getItem('id'))).subscribe((response: any) => {
      if(response.status == 200 && response.data) {
        this.user_data = response.data;

        this.courseService.getRanking(String(this.id_course)).subscribe((rank: any) => {
          if(rank.status == 200) {
            this.ranking = rank.data;

            this.dataLoaded = Promise.resolve(true);
          } else {
            this.authService.logout();
          }
        });
      } else {
        this.authService.logout();
      }
    });
  }

  changeType() {
    this.ranking_list = !this.ranking_list;
  }
}
