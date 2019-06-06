import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CrawlingComponent } from './crawling.component';

describe('CrawlingComponent', () => {
  let component: CrawlingComponent;
  let fixture: ComponentFixture<CrawlingComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CrawlingComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CrawlingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
