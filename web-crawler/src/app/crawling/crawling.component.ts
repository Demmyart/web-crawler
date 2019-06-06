import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { RequestsService } from '../requests.service';
import { mergeMap, takeWhile } from "rxjs/operators";
import { takeUntil } from 'rxjs/operators';
import { interval, Observable } from 'rxjs';

export interface targetType {
  name: string;
}

@Component({
  selector: 'app-crawling',
  templateUrl: './crawling.component.html',
  styleUrls: ['./crawling.component.css']
})
export class CrawlingComponent implements OnInit {

  targetTypes: targetType[] = [
    { name: 'Nickname' },
    { name: 'Gang name' },
    { name: 'Email' },
  ];

  isLinear = false;
  firstFormGroup: FormGroup;
  secondFormGroup: FormGroup;
  isFinished = false;
  isLoading = false;
  listUrl: any[] = [];
  selectedUrls: any[] = [];
  results: any[] = [];

  keywordControl = new FormControl('', [Validators.required]);
  targetControl = new FormControl('', [Validators.required]);
  depthControl = new FormControl('', [Validators.required]);


  constructor(private _formBuilder: FormBuilder, private http: RequestsService) { }

  ngOnInit() {
    this.firstFormGroup = this._formBuilder.group({
      // firstCtrl: ['', Validators.required]
    });
    this.secondFormGroup = this._formBuilder.group({
      // secondCtrl: ['', Validators.required]
    });
  }

  getURLs() {
    if (this.listUrl.length == 0) {
      this.http.getURLs().subscribe(data => {
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
  }

  sendRequest() {
    let arr = [];
    let id: any;
    for (let i in this.selectedUrls) {
      arr.push(this.selectedUrls[i].id);
    }
    this.http.search(arr, this.targetControl.value.name, this.keywordControl.value, this.depthControl.value).subscribe(data => {
      id = data.id;
    });


    const subscription = interval(10000)
      .pipe(
        mergeMap(() => this.http.fuck(id)))
        .subscribe(data => {
        this.isLoading =true;
        this.results = [];
        this.results = data.grabResults;
        // console.log(this.results);
        if (data.isFinished == true) {
          subscription.unsubscribe();
          this.isLoading =false;

        }
      }
      );

  // console.log(this.selectedUrls);
  // console.log(this.targetControl.value.name + ' ' + this.keywordControl.value + arr + this.depthControl.value);
}

  // this.firstFormGroup.get('firstCtrl').value
  // formBuilder instead of it :
  // firstFormGroup = new FormGroup({ firstCtrl: new FormControl ('', Validators.required)});
  // secondFormGroup = new FormGroup({ secondCtrl: new FormControl ('', Validators.required)});
}
