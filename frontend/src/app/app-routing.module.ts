import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import { NotfoundPageComponent } from './notfound-page/notfound-page.component';
import { IsAuthenticatedGuard } from './services/auth/isAuthenticatedGuard';
import { LoginComponent } from './users/login/login.component';
import { RegisterComponent } from './users/register/register.component';
import { NavbarComponent } from './manager/navbar/navbar.component';


const routes: Routes = [
  {path: '', redirectTo: '/manager', pathMatch: 'full'},
  {path: 'manager', loadChildren: () => import('./manager/manager.module').then((m) => m.ManagerModule), canActivate: [IsAuthenticatedGuard]},
  {path: 'login',  component: LoginComponent},
  {path: 'register',  component: RegisterComponent},
  {path: 'navbar',  component: NavbarComponent},
  {path: '404',  component: NotfoundPageComponent}, //temporal
  {path: '**', redirectTo: '/manager', pathMatch: 'full'}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule {}
