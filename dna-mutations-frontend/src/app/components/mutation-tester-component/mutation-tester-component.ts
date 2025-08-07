import { CommonModule } from '@angular/common';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Component, Input } from '@angular/core';
import { FormsModule } from '@angular/forms';

@Component({
  standalone: true,
  selector: 'app-mutation-tester-component',
  imports: [FormsModule, HttpClientModule, CommonModule],
  templateUrl: './mutation-tester-component.html',
  styleUrl: './mutation-tester-component.css'
})
export class MutationTesterComponent {
  @Input() apiUrl = 'https://dna-mutations.duckdns.org/api';
  dnaInput: string = '';
  loading: boolean = false;
  result: any = null;
  history: { dna: string[]; result: string }[] = [];

  constructor(private readonly http: HttpClient) {}

  async testMutation() {
    const dna = this.dnaInput
      .trim()
      .split('\n')
      .map(line => line.trim().toUpperCase())
      .filter(line => line.length > 0);
    if (dna.length === 0) {
      this.result = { message: 'Please enter a DNA sequence.', mutation: null };
      return;
    }
    this.loading = true;
    this.result = null;
    try {
      const response = await this.http
        .post<{ message: string; mutation: boolean }>(`${this.apiUrl}/mutation`, { dna }, { observe: 'response' })
        .toPromise();
      if (response && response.body) {
        const mutation = response.body.mutation;
        this.result = {
          message: response.body.message,
          mutation
        };
        this.history.unshift({
          dna,
          result: mutation ? 'Mutation' : 'No Mutation'
        });
      } else {
        this.result = { message: 'Unexpected response', mutation: null };
      }
    } catch (err: any) {
      if (err.status === 422) {
        this.result = { message: err.error?.error || 'Invalid data', mutation: null };
      } else if (err.status === 403) {
        this.result = {
          message: err.error?.message || 'No mutation detected.',
          mutation: false
        };
      } else {
        this.result = { message: 'Server error', mutation: null };
      }
    } finally {
      this.loading = false;
    }
  }


  clearInput() {
    this.dnaInput = '';
    this.result = null;
  }
}
