import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditCollegeComponent } from './edit-college.component';

describe('EditCollegeComponent', () => {
  let component: EditCollegeComponent;
  let fixture: ComponentFixture<EditCollegeComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ EditCollegeComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(EditCollegeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
