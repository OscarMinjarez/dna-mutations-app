import { Component } from '@angular/core';
import { MutationTesterComponent } from "../../components/mutation-tester-component/mutation-tester-component";
import { StatsHeaderComponent } from "../../components/stats-header-component/stats-header-component";
import { RecentMutationsComponent } from "../../components/recent-mutations-component/recent-mutations-component";

@Component({
  selector: 'app-home-view',
  imports: [MutationTesterComponent, StatsHeaderComponent, RecentMutationsComponent],
  templateUrl: './home-view.html',
  styleUrl: './home-view.css'
})
export class HomeView {
  
}
