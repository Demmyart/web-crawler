import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';

@Injectable({
  providedIn: 'root'
})

export class RequestsService {

  // private corsHeaders: HttpHeaders;
  private nameserver = 'http://localhost:8080/';

  constructor(private http: HttpClient) {
    // this.corsHeaders = new HttpHeaders({ 'Content-Type': 'application/json', 'Accept': 'application/json', 'Access-Control-Allow-Origin': 'http://localhost:8080' });
  }

  getURLs(): Observable<any> {
    return this.http.get(this.nameserver + `site/list`);
  }

  addInstance(urlFormControl: any): Observable<any> {
    const formData: FormData = new FormData();
    formData.append('url', urlFormControl);
    return this.http.post(this.nameserver + `site/create`, formData);
  }

  deleteInstance(selecterUrls: any): Observable<any> {
    // for (let i in selecterUrls){
    return this.http.post(this.nameserver + `site/delete/` + selecterUrls, ``);
    // }
  }

  search(sites: any[], type: any, keyword: any, depth: any): Observable<any> {
    const formData: FormData = new FormData();
    for (let i in sites) {
      formData.append('sites[]', sites[i]);
    }
    formData.append('username', keyword);
    formData.append('depth', depth);
    return this.http.post(this.nameserver + `search/create`, formData);
  }

  fuck(id: any): Observable<any> {
    return this.http.get(this.nameserver + `search/` + id);
  }
}
