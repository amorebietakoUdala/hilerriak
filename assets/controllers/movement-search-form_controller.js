import { Controller } from '@hotwired/stimulus';
import $ from 'jquery';

import '../styles/common/select2.css';
import 'select2/dist/js/select2.full.js';
import 'select2/dist/js/i18n/es.js';
import 'select2/dist/js/i18n/eu.js';

export default class extends Controller {
   static targets = [
      'typeInput', 
      'sourceInput',
      'destinationTypeInput',
      'destinationInput', 
      'expedientNumberInput', 
      'registrationNumberInput', 
      'defunctNameInput', 
      'defunctSurname1Input', 
      'defunctSurname2Input', 
      'deceaseDateInput',
      'finalizedInput',
   ];
   static values = {
      locale: String,
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

   clean(e) {
      e.preventDefault();
      if ( this.hasTypeInputTarget ) {
         this.typeInputTarget.value='';
      }
      if ( this.hasSourceInputTarget ) {
         this.sourceInputTarget.value='';
         $(this.sourceInputTarget).trigger('change');
      }
      if ( this.hasDestinationTypeInputTarget ) {
         this.destinationTypeInputTarget.value='';
         $(this.destinationTypeInputTarget).trigger('change');
      }
      if ( this.hasDestinationInputTarget ) {
         this.destinationInputTarget.value='';
         $(this.destinationInputTarget).trigger('change');
      }
      if ( this.hasExpedientNumberInputTarget ) {
         this.expedientNumberInputTarget.value='';
      }
      if ( this.hasRegistrationNumberInputTarget ) {
         this.registrationNumberInputTarget.value='';
      }
      if ( this.hasDefunctNameInputTarget ) {
         this.defunctNameInputTarget.value='';
      }
      if ( this.hasDefunctSurname1InputTarget ) {
         this.defunctSurname1InputTarget.value='';
      }
      if ( this.hasDefunctSurname2InputTarget ) {
         this.defunctSurname2InputTarget.value='';
      }
      if ( this.hasDeceaseDateInputTarget ) {
         this.deceaseDateInputTarget.value='';
      }
      if ( this.hasFinalizedInputTarget ) {
         this.finalizedInputTarget.value='';
      }
   }
}