import { Controller } from '@hotwired/stimulus';
import $ from 'jquery';

import '../styles/common/select2.css';
import 'select2/dist/js/select2.full.js';
import 'select2/dist/js/i18n/es.js';
import 'select2/dist/js/i18n/eu.js';

import Swal from 'sweetalert2';

export default class extends Controller {
   static targets = ['cemeteryInput', 'graveInput', 'ownerInput','addMovementInput', 'currentInput'];
   static values = {
      gravesServiceUrl: String,
      ownersServiceUrl: String,
      locale: String,
   };

   connect() {
      let options = {
         theme: "bootstrap-5",
         language: this.localeValue,
         placeholder: ""
      };
      $(this.graveInputTarget).select2(options);
      if ( this.hasCemeteryInputTarget ) {
         $(this.cemeteryInputTarget).append($('<option>', {
            value: '',
            text: ''
         }));
         options = {
            theme: "bootstrap-5",
            language: this.localeValue,
         };
         $(this.cemeteryInputTarget).select2(options);
         $(this.ownerInputTarget).select2(options);
         $(this.cemeteryInputTarget).on('select2:select', function(e) {
            let event = new Event('change', { bubbles: true })
            e.currentTarget.dispatchEvent(event);
         });
      }
   }

   async refreshGraves(event) {
      let cemetery = $(event.currentTarget).val();
      if ( cemetery !== "") {
         let url = this.gravesServiceUrlValue;
         let params = new URLSearchParams({
            'cemetery' : cemetery,
         });
         await fetch(url+'?'+params.toString())
            .then( result => result.json() )
            .then( graves => {
               $(this.graveInputTarget).find('option').remove().end().append($('<option>', { value : '' }).text(''));
               for ( let grave of graves ) {
                     $(this.graveInputTarget).append($('<option>', { value : grave.id }).text(grave.code));
               }
            });
      }
   }

   async refreshOwners(event) {
      let cemetery = $(event.currentTarget).val();
      if ( cemetery !== "") {
         let url = this.ownersServiceUrlValue;
         let params = new URLSearchParams({
            'cemetery' : cemetery,
         });
         await fetch(url+'?'+params.toString())
            .then( result => result.json() )
            .then( owners => {
               $(this.ownerInputTarget).find('option').remove().end().append($('<option>', { value : '' }).text(''));
               for ( let owner of owners ) {
                     $(this.ownerInputTarget).append($('<option>', { value : owner.id }).text(owner.fullname));
               }
            });
      }
   }

   onSubmit(e) {
      e.preventDefault();
      const form = e.currentTarget;
      const addMovementInput = this.addMovementInputTarget;
      Swal.fire({
         template: '#confirm'
      }).then(function (result) {
            if (result.value) {
               addMovementInput.value = 1;
            } else {
               addMovementInput.value = 0;
            }
            form.submit();
         });
      return;
   }

   // async onKeyPress(event) {
   //    let dni = $(event.currentTarget).val();
   //    console.log(dni);
   //    console.log(dni.length);
   //    if ( dni !== "" && dni.length > 2 ) {
   //       let url = this.ownerServiceUrlValue;
   //       let params = new URLSearchParams({
   //          'dni' : dni,
   //       });
   //                await fetch(url+'?'+params.toString())
   //            .then( result => result.json() )
   //            .then( owners => {
   //                console.log(owners);
   //                $(this.ownerInputTarget).find('option').remove().end().append($('<option>', { value : '' }).text(''));
   //                let seleted = '';
   //                for ( let owner of owners ) {
   //                   $(this.ownerInputTarget).append($('<option>', { value : owner.id }).text(grave.code));
   //                   selected = owner.id;
   //                }
   //                if (owners.length == 1) {
   //                   console.log(this.ownerInputTarget.options[0]);
   //                   this.ownerInputTarget.val(seleted);
   //                }
   //             });
   //    }
   // }

   search(event) {
      let graves = $(this.gravesInputTarget).val();
      let cemetery = $(this.cemeteryInputTarget).val('');
      if ( this.hasCemeteryInputTarget ) {
         cemetery = $(this.cemeteryInputTarget).val();
      }
      this.dispatch('search',{ detail: {
         grave : graves,
         cemetery: cemetery,
      }});
   }

   clean(event) {
      if (this.hasGraveInputTarget) {
         $(this.graveInputTarget).val('');
         $(this.graveInputTarget).find('option').remove().end().append($('<option>', { value : '' }).text(''));
         $(this.graveInputTarget).trigger('change');
      }
      if (this.hasCemeteryInputTarget) {
         $(this.cemeteryInputTarget).val('');
         $(this.cemeteryInputTarget).trigger('change');
      }
      if (this.hasOwnerInputTarget) {
         $(this.ownerInputTarget).val('');
         $(this.ownerInputTarget).trigger('change');
      }
      if (this.hasCurrentInputTarget) {
         $(this.currentInputTarget).val('');
      }
      this.search(event);
   }




   
}