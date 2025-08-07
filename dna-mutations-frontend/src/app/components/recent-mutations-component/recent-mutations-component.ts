import { CommonModule } from '@angular/common';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Component } from '@angular/core';

@Component({
  selector: 'app-recent-mutations-component',
  imports: [HttpClientModule, CommonModule],
  templateUrl: './recent-mutations-component.html',
  styleUrl: './recent-mutations-component.css'
})
export class RecentMutationsComponent {

  stats: any = null;
  loading: boolean = true;
  apiUrl = 'https://dna-mutations.duckdns.org/api';
  sequences: any[] = [];
  pagination: any = {};

  currentPage = 1;

  constructor(private http: HttpClient) {
  }

  ngOnInit() {
    this.loadPage(1);
  }

  async loadPage(page: number) {
    this.loading = true;
    try {
      const response: any = await this.http.get(`${this.apiUrl}/stats?page=${page}`).toPromise();
      this.sequences = response.data;
      this.pagination = response;
      this.currentPage = response.current_page;
    } catch (error) {
      console.error('Error loading sequences:', error);
    } finally {
      this.loading = false;
    }
  }
}
