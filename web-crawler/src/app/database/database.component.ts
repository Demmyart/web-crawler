import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroupDirective, NgForm, Validators } from '@angular/forms';
import { RequestsService } from '../requests.service';

@Component({
  selector: 'app-database',
  templateUrl: './database.component.html',
  styleUrls: ['./database.component.css']
})
export class DatabaseComponent implements OnInit {

  selectedUrls: any[] = [];
  listUrl: any[] = [];
  urlFormControl = new FormControl('', [Validators.required]);

  constructor(private http: RequestsService) { }

  ngOnInit() {
  }

  addInstance() {
    this.http.addInstance(this.urlFormControl.value).subscribe(data => {
      // console.log(data);
    });
    this.listUrl = [];
  }

  deleteInstance() {
    for (let i in this.selectedUrls) {
      this.http.deleteInstance(this.selectedUrls[i].id).subscribe(data => {
        // console.log(data);
      });

    }
    this.listUrl = [];
    this.selectedUrls = [];

  }


  getURLs() {
    if (this.listUrl.length == 0) {
      this.http.getURLs().subscribe(data => {
        // console.log(data);
        this.listUrl = data;
      });
    }
  }


  selectURL(url) {
    if (this.selectedUrls.indexOf(url) == -1) {
      this.selectedUrls.push(url);
    }
    else {
      this.selectedUrls.pop();
    }
    // console.log(url);
    // console.log(this.selectedUrls);
  }

}
