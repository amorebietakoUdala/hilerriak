import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
   static targets = ['dniInput', 'fullnameInput'];

   clean(e) {
         this.dniInputTarget.value='';
         this.fullnameInputTarget.value='';
   }
}