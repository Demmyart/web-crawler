import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {MatStepperModule, MatInputModule, MatButtonModule} from '@angular/material'
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import { HttpClientModule }    from '@angular/common/http';

import {MatExpansionModule} from '@angular/material/expansion'; 
import {MatSelectModule} from '@angular/material/select'; 
import {MatDividerModule} from '@angular/material/divider'; 
import {MatListModule} from '@angular/material/list'; 
import {MatRadioModule} from '@angular/material/radio'; 


import {MatIconModule} from '@angular/material/icon'; 

import {MatMenuModule} from '@angular/material/menu'; 
import { AppComponent } from './app.component';
import {RequestsService} from './requests.service';
import { CrawlingComponent } from './crawling/crawling.component';
import { DatabaseComponent } from './database/database.component';
import { AppRoutingModule } from './app-routing.module';

@NgModule({
  declarations: [
    AppComponent,
    CrawlingComponent,
    DatabaseComponent
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    MatStepperModule, MatInputModule, MatButtonModule,
    FormsModule,
    ReactiveFormsModule,
    MatDividerModule,
    MatSelectModule,
    MatExpansionModule,
    HttpClientModule,
    MatListModule,
    MatRadioModule,
    MatMenuModule,
    MatIconModule,
    AppRoutingModule
  ],
  providers: [RequestsService],
  bootstrap: [AppComponent]
})
export class AppModule { }
