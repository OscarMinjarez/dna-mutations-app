import { CommonModule } from '@angular/common';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Component } from '@angular/core';

@Component({
  selector: 'app-stats-header-component',
  imports: [HttpClientModule, CommonModule],
  templateUrl: './stats-header-component.html',
  styleUrl: './stats-header-component.css'
})
export class StatsHeaderComponent {
stats: {
    count_mutations: number;
    count_no_mutation: number;
    ratio: number;
  } | null = null;

  apiUrl = 'https://dna-mutations.duckdns.org/api';
  loading = true;

  constructor(private http: HttpClient) {}

  ngOnInit() {
    this.loadStats();
  }

  async loadStats() {
    try {
      const response: any = await this.http.get(`${this.apiUrl}/stats/all`).toPromise();
      this.stats = response;
    } catch (error) {
      console.error('Error fetching stats:', error);
    } finally {
      this.loading = false;
    }
  }

  totalAnalyses(): number {
    if (!this.stats) return 0;
    return this.stats.count_mutations + this.stats.count_no_mutation;
  }

  mutationPercentage(): string {
    const total = this.totalAnalyses();
    return total > 0 ? ((this.stats!.count_mutations / total) * 100).toFixed(1) : '0.0';
  }
}
