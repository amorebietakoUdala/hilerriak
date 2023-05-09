import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
   static targets = ['letterInput', 'highInput', 'widthInput'];
   static values = {
      locale: String,
      typePit: String,
      typePanteon: String,
   };

   onChange(e) {
      const type = e.currentTarget.value;
      // Panteon or Pit
      if ( type == this.typePanteonValue || type == this.typePitValue) {
         this.highInputTarget.value = 1;
         this.highInputTarget.setAttribute('readonly', 'readonly');
      } else {
         this.highInputTarget.value = '';
         this.highInputTarget.removeAttribute('readonly', 'readonly');
      }
   }
}