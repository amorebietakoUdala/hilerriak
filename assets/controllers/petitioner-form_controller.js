import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
   static targets = [
      'dniInput', 
      'nameInput',
      'surname1Input',
      'surname2Input', 
      'telephoneInput', 
      'emailInput', 
   ];
   static values = {
      locale: String,
   };

   connect() {
      console.log('petitioner form controller');
   }

   clean(e) {
      e.preventDefault();
      if ( this.hasDniInputTarget ) {
         this.dniInputTarget.value='';
      }
      if ( this.hasNameInputTarget ) {
         this.nameInputTarget.value='';
      }
      if ( this.hasSurname1InputTarget ) {
         this.surname1InputTarget.value='';
      }
      if ( this.hasSurname2InputTarget ) {
         this.surname2InputTarget.value='';
      }
      if ( this.hasTelephoneInputTarget ) {
         this.telephoneInputTarget.value='';
      }
      if ( this.hasEmailInputTarget ) {
         this.emailInputTarget.value='';
      }
   }
}