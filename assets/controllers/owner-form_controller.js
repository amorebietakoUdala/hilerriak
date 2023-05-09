import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
   static targets = ['fullNameRow', 'dniRow'];

   onToggle(e) {
      const checked = e.currentTarget.checked;
      if (checked) {
         this.fullNameRowTarget.classList.remove('d-none');
         this.dniRowTarget.classList.add('d-none');
      } else {
         this.fullNameRowTarget.classList.add('d-none');
         this.dniRowTarget.classList.remove('d-none');
      }
   }
}