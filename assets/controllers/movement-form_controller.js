import { Controller } from '@hotwired/stimulus';
import $ from 'jquery';

import '../styles/common/select2.css';
import 'select2/dist/js/select2.full.js';
import 'select2/dist/js/i18n/es.js';
import 'select2/dist/js/i18n/eu.js';

export default class extends Controller {
   static targets = ['sourceInput', 'destinationTypeInput', 'destinationRow', 'destinationInput', 'deceaseDateInput', 'wantsToBePresentRow'];
   static values = {
      locale: String,
      destinationTypeGrave: Number,
      destinationTypeHumanRemainsBox: Number,
      exhumationType: Number,
      inhumationType: Number,
   };

   connect() {
      let options = {
         theme: "bootstrap-5",
         language: this.localeValue,
         placeholder: "",
         allowClear: true,
      };
      if ( this.hasSourceInputTarget ) {
         $(this.sourceInputTarget).select2(options);
      }
      if ( this.hasDestinationInputTarget ) {
         $(this.destinationInputTarget).select2(options);
      }
   }

   onTypeChange(e) {
      e.preventDefault();
      const type = e.currentTarget;
      if (type.value == this.exhumationTypeValue) {
         this.wantsToBePresentRowTarget.classList.remove('d-none');
      } else {
         this.wantsToBePresentRowTarget.classList.add('d-none');
      }
      if (type.value == this.inhumationTypeValue) {
         this.destinationTypeInputTarget.value="1";
         this.destinationTypeInputTarget.dispatchEvent(new Event('change'));
         this.destinationTypeInputTarget.setAttribute('disabled',true);
      } else {
         this.destinationTypeInputTarget.removeAttribute('disabled');
      }
   } 

   onDestinationTypeChange(e) {
      e.preventDefault();
      const destinationType = e.currentTarget;
      if (destinationType.value == this.destinationTypeGraveValue || destinationType.value == this.destinationTypeHumanRemainsBoxValue ) {
         this.destinationRowTarget.classList.remove('d-none');
      } else {
         this.destinationRowTarget.classList.add('d-none');
         this.destinationInputTarget.value='';
         $(this.destinationInputTarget).trigger('change');
      }
   }

   onSubmit(e) {
      e.preventDefault();
      this.destinationTypeInputTarget.removeAttribute('disabled');
      e.currentTarget.submit();
   }
}