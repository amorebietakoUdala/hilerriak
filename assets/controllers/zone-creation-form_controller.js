import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
   static targets = ['letterInput', 'letterRow', 'zoneInput', 'zoneRow', 'highInput', 'widthInput', 'typeInput', 'yearsInput'];
   static values = {
      locale: String,
      typePit: String,
      typePanteon: String,
      typeSlab: String,
   };

   connect() {
      if (this.letterInputTarget.value != null && this.letterInputTarget.value != '') {
         const type = this.typeInputTarget.value;
         this.change(type);
      }
   }

   onChange(e) {
      const type = e.currentTarget.value;
      this.change(type);
   }

   change(type) {
      // Panteon or Pit or Slab
      if ( type == this.typePanteonValue ) {
         this.zoneRowTarget.classList.remove('d-none');
         this.letterRowTarget.classList.add('d-none');
         this.letterInputTarget.value='P';
      } else {
         this.zoneRowTarget.classList.add('d-none');
         this.letterRowTarget.classList.remove('d-none');
         this.letterInputTarget.value='';
      }
      if ( type == this.typePanteonValue || type == this.typePitValue || type == this.typeSlabValue) {
         this.highInputTarget.value = 1;
         this.highInputTarget.setAttribute('readonly', 'readonly');
      } else {
         this.highInputTarget.value = '';
         this.highInputTarget.removeAttribute('readonly', 'readonly');
      }
   }
}