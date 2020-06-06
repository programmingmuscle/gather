(function() {
    const isLeapYear = year => (year % 4 === 0) && (year % 100 !== 0) || (year % 400 === 0);
    const countDaysOfFeb = year => isLeapYear(year) ? 29 : 28;
    const createOption = (id, startNum, endNum, current) => {
      const selectDom = document.getElementById(id);
      let optionDom = '';
      for (let i = startNum; i <= endNum; i++) {
        if (i == current) {
          option = '<option value="' + i + '" selected>' + i + '</option>';
        } else {
          option = '<option value="' + i + '">' + i + '</option>';
        }
        optionDom += option;
      }
      selectDom.insertAdjacentHTML('beforeend', optionDom);
    }
  
    const yearBox = document.getElementById('eYear');
    const monthBox = document.getElementById('eMonth');
    const dayBox = document.getElementById('eDay');
  
    const today = new Date();
    const thisYear = today.getFullYear();
    const thisMonth = today.getMonth() + 1;
  
    let daysOfYear= [31, countDaysOfFeb(thisYear), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
  
    monthBox.addEventListener('change', (e) => {
          dayBox.innerHTML = '';
          const selectedMonth = e.target.value;
          createOption('eDay', 1, daysOfYear[selectedMonth - 1], 1);
      });
  
      yearBox.addEventListener('change', e => {
          monthBox.innerHTML = '';
          dayBox.innerHTML = '';
          const updatedYear = e.target.value;
          daysOfYear = [31, countDaysOfFeb(updatedYear), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
  
          createOption('eMonth', 1, 12, 1);
          createOption('eDay', 1, daysOfYear[0], 1);
      });
      
      createOption('eYear', thisYear, thisYear + 1, postDateTimeArray[0]);
      createOption('eMonth', 1, 12, postDateTimeArray[1]);
      createOption('eDay', 1, daysOfYear[thisMonth - 1], postDateTimeArray[2]);
  })();
  
  (function() {
    const isLeapYear = year => (year % 4 === 0) && (year % 100 !== 0) || (year % 400 === 0);
    const countDaysOfFeb = year => isLeapYear(year) ? 29 : 28;
    const createOption = (id, startNum, endNum, current) => {
      const selectDom = document.getElementById(id);
      let optionDom = '';
      for (let i = startNum; i <= endNum; i++) {
        if (i == current) {
          option = '<option value="' + i + '" selected>' + i + '</option>';
        } else {
          option = '<option value="' + i + '">' + i + '</option>';
        }
        optionDom += option;
      }
      selectDom.insertAdjacentHTML('beforeend', optionDom);
    }
  
    const yearBox = document.getElementById('edYear');
    const monthBox = document.getElementById('edMonth');
    const dayBox = document.getElementById('edDay');
  
    const today = new Date();
    const thisYear = today.getFullYear();
    const thisMonth = today.getMonth() + 1;
  
    let daysOfYear= [31, countDaysOfFeb(thisYear), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
  
    monthBox.addEventListener('change', (e) => {
          dayBox.innerHTML = '';
          const selectedMonth = e.target.value;
          createOption('edDay', 1, daysOfYear[selectedMonth - 1], 1);
      });
  
      yearBox.addEventListener('change', e => {
          monthBox.innerHTML = '';
          dayBox.innerHTML = '';
          const updatedYear = e.target.value;
          daysOfYear = [31, countDaysOfFeb(updatedYear), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
  
          createOption('edMonth', 1, 12, 1);
          createOption('edDay', 1, daysOfYear[0], 1);
      });
  
      createOption('edYear', thisYear, thisYear + 1, postDeadlineArray[0]);
      createOption('edMonth', 1, 12, postDeadlineArray[1]);
      createOption('edDay', 1, daysOfYear[thisMonth - 1], postDeadlineArray[2]);
  })();
  
  $('.p-edit-form').on('submit', (e) => {
      const title = $('#title').val();
      const place = $('#place').val();
      const address = $('#address').val();
      const expense = $('#expense').val();
      const date_time = ($('#eYear').val() + '/' + $('#eMonth').val() + '/' + $('#eDay').val() + ' ' + $('#eFrom_hour').val() + ':' + $('#eFrom_minute').val());
      const date_time_to = ($('#eYear').val() + '/' + $('#eMonth').val() + '/' + $('#eDay').val() + ' ' + $('#eTo_hour').val() + ':' + $('#eTo_minute').val());
      const deadline = ($('#edYear').val() + '/' + $('#edMonth').val() + '/' + $('#edDay').val() + ' ' + $('#edHour').val() + ':' + $('#edMinute').val());
      const date = new Date(date_time);
      const date_to = new Date(date_time_to);
      const dDate = new Date(deadline);
  
      if(date >= date_to) {
        e.preventDefault();
  
        $('#remove-error-content').remove();
  
        $('.remove-error-date_time').remove();
  
        $('<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>').prependTo('#content');
        
        $('<div class="error-target remove-error-date_time">終了時間は開催時間より後の時間で設定して下さい。</div>').insertAfter('#date_time-error');
  
        $('html, body').animate({ scrollTop: 0 }, 600);
      } else {
          $('.remove-error-date_time').remove();
      }
      
      if(date <= dDate) {
          e.preventDefault();
  
          $('#remove-error-content').remove();
  
          $('.remove-error-deadline').remove();
  
          $('<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>').prependTo('#content');
  
          $('<div class="error-target remove-error-deadline">応募締切は開催日時より前の日時で設定して下さい。</div>').insertAfter('#deadline-error');
  
          $('html, body').animate({ scrollTop: 0 }, 600);
      } else {
          $('.remove-error-deadline').remove();
      }
  
      if (title === '') {
  
          e.preventDefault();
  
          $('#remove-error-content').remove();
  
          $('.remove-error-title').remove();
  
          $('<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>').prependTo('#content');
  
          $('<div class="error-target remove-error-title">タイトルを入力して下さい。</div>').insertAfter('#title-error');
  
          $('html, body').animate({ scrollTop: 0 }, 600);
      } else {
          $('.remove-error-title').remove();
      }
  
      if (place === '') {
  
          e.preventDefault();
  
          $('#remove-error-content').remove();
  
          $('.remove-error-place').remove();
  
          $('<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>').prependTo('#content');
  
          $('<div class="error-target remove-error-place">場所を入力して下さい。</div>').insertAfter('#place-error');
          
          $('html, body').animate({ scrollTop: 0 }, 600);
      } else {
          $('.remove-error-place').remove();
      }
  
      if (address === '') {
  
          e.preventDefault();
  
          $('#remove-error-content').remove();
  
          $('.remove-error-address').remove();
  
          $('<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>').prependTo('#content');
  
          $('<div class="error-target remove-error-address">住所を入力して下さい。</div>').insertAfter('#address-error');
  
          $('html, body').animate({ scrollTop: 0 }, 600);
      } else {
          $('.remove-error-address').remove();
      }
  
      if (expense === '') {
  
          e.preventDefault();
  
          $('#remove-error-content').remove();
  
          $('.remove-error-expense').remove();
  
          $('<p class="error-message alert alert-danger list-unstyled" id="remove-error-content" role="alert">入力に問題があります。再入力して下さい。</p>').prependTo('#content');
  
          $('<div class="error-target remove-error-expense">参加費用を入力して下さい。</div>').insertAfter('#expense-error');
  
          $('html, body').animate({ scrollTop: 0 }, 600);
      } else {
          $('.remove-error-expense').remove();
      }
  });