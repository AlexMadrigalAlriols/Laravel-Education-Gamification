import { ComponentFixture, TestBed } from '@angular/core/testing';

import { UserSubmitsListComponent } from './user-submits-list.component';

describe('UserSubmitsListComponent', () => {
  let component: UserSubmitsListComponent;
  let fixture: ComponentFixture<UserSubmitsListComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ UserSubmitsListComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(UserSubmitsListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
