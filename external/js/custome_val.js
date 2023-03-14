$(function () {
    'use strict';
//onkeypress="if(this.value.length==10) return false;"
      jQuery('.numbersOnly').keyup(function () {
      this.value = this.value.replace(/[^0-9\.]/g,'');
      });

      jQuery('.lettersOnly').keyup(function () {
      this.value = this.value.replace(/[^a-zA-Z\s]+$/g,'');
      });

      jQuery('.alphanimericOnly').keyup(function () {
      this.value = this.value.replace(/[^A-Za-z0-9.\/\s]/g,'');
      });

      jQuery('.address').keyup(function () {
      this.value = this.value.replace(/[^A-Za-z0-9//,.\/\s]/g,'');

      });

      jQuery('.nospace').keyup(function () {
      this.value = this.value.replace(/[^A-Za-z0-9]+$/g,'');
      });

      jQuery('.contentOnly').keyup(function () {
      this.value = this.value.replace(/[^0-9a-zA-Z\. ]/g,'');
      });

      jQuery('.emailOnly').keyup(function () {
      this.value = this.value.replace(/[^@_a-zA-Z0-9\.]/g,'');
      });

      jQuery('.uppercase').keyup(function () {
      this.value = this.value.replace(/[^A-Za-z0-9 ]+$/g,'').toUpperCase();
      });

      jQuery('.lowercase').keyup(function () {
      this.value = this.value.replace(/[^A-Za-z0-9]+$/g,'').toUpperCase();
      });

      jQuery('.ucwords').keyup(function () {
      var vall = this.value.replace(/[^A-Za-z0-9 ]+$/g,'');
      this.value = capitalizeFirstLetters( vall );
      });

  });