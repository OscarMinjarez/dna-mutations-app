import { ComponentFixture, TestBed } from '@angular/core/testing';

import { RecentMutationsComponent } from './recent-mutations-component';

describe('RecentMutationsComponent', () => {
  let component: RecentMutationsComponent;
  let fixture: ComponentFixture<RecentMutationsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [RecentMutationsComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(RecentMutationsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
