import { Controller } from '@hotwired/stimulus';
import $ from 'jquery';

import '../styles/common/select2.css';
import 'select2/dist/js/select2.full.js';
import 'select2/dist/js/i18n/es.js';
import 'select2/dist/js/i18n/eu.js';

export default class extends Controller {
   static targets = ['sourceInput', 'destinationTypeInput', 'destinationRow', 'destinationInput', 'deceaseDateInput'];
   static values = {
      locale: String,
      destinationTypeGrave: Number,
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

   onDestinationTypeChange(e) {
      e.preventDefault();
      const destinationType = e.currentTarget;
      if (destinationType.value == this.destinationTypeGraveValue) {
         this.destinationRowTarget.classList.remove('d-none');
      } else {
         this.destinationRowTarget.classList.add('d-none');
         this.destinationInputTarget.value='';
         $(this.destinationInputTarget).trigger('change');
      }
   }
}