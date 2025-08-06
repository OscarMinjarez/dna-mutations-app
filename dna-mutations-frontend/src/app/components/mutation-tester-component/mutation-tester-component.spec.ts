import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MutationTesterComponent } from './mutation-tester-component';

describe('MutationTesterComponent', () => {
  let component: MutationTesterComponent;
  let fixture: ComponentFixture<MutationTesterComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [MutationTesterComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MutationTesterComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
