import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NewPoperComponent } from './new-poper.component';

describe('NewPoperComponent', () => {
  let component: NewPoperComponent;
  let fixture: ComponentFixture<NewPoperComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ NewPoperComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(NewPoperComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
