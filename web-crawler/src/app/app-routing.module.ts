import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import {DatabaseComponent} from './database/database.component';
import {CrawlingComponent} from './crawling/crawling.component';

const routes: Routes = [
  { path: '', redirectTo: '/crawling', pathMatch: 'full' },
  { path: 'crawling', component: CrawlingComponent },
  { path: 'database', component: DatabaseComponent }
];


@NgModule({
  imports: [
    RouterModule.forRoot(routes)
  ],
  exports: [ RouterModule ]
})
export class AppRoutingModule { }
