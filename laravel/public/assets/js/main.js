(function() {
  const isLeapYear = year => (year % 4 === 0) && (year % 100 !== 0) || (year % 400 === 0);
  const countDaysOfFeb = year => isLeapYear(year) ? 29 : 28;
  const createOption = (id, startNum, endNum, current) => {
    const selectDom = document.getElementById(id);
    let optionDom = '';
    for (let i = startNum; i <= endNum; i++) {
      if (i === current) {
        option = '<option value="' + i + '" selected>' + i + '</option>';
      } else {
        option = '<option value="' + i + '">' + i + '</option>';
      }
      optionDom += option;
    }
    selectDom.insertAdjacentHTML('beforeend', optionDom);
  }

  const yearBox = document.getElementById('year');
  const monthBox = document.getElementById('month');
  const dayBox = document.getElementById('day');

  const today = new Date();
  const thisYear = today.getFullYear();
  const thisMonth = today.getMonth() + 1;
  const thisDay = today.getDate();

  let daysOfYear= [31, countDaysOfFeb(thisYear), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

  monthBox.addEventListener('change', (e) => {
        dayBox.innerHTML = '';
        const selectedMonth = e.target.value;
        createOption('day', 1, daysOfYear[selectedMonth - 1], 1);
    });

    yearBox.addEventListener('change', e => {
        monthBox.innerHTML = '';
        dayBox.innerHTML = '';
        const updatedYear = e.target.value;
        daysOfYear = [31, countDaysOfFeb(updatedYear), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        createOption('month', 1, 12, 1);
        createOption('day', 1, daysOfYear[0], 1);
    });

    createOption('year', thisYear, thisYear + 1, thisYear);
    createOption('month', 1, 12, thisMonth);
    createOption('day', 1, daysOfYear[thisMonth - 1], thisDay);
})();

(function() {
  const isLeapYear = year => (year % 4 === 0) && (year % 100 !== 0) || (year % 400 === 0);
  const countDaysOfFeb = year => isLeapYear(year) ? 29 : 28;
  const createOption = (id, startNum, endNum, current) => {
    const selectDom = document.getElementById(id);
    let optionDom = '';
    for (let i = startNum; i <= endNum; i++) {
      if (i === current) {
        option = '<option value="' + i + '" selected>' + i + '</option>';
      } else {
        option = '<option value="' + i + '">' + i + '</option>';
      }
      optionDom += option;
    }
    selectDom.insertAdjacentHTML('beforeend', optionDom);
  }

  const yearBox = document.getElementById('dYear');
  const monthBox = document.getElementById('dMonth');
  const dayBox = document.getElementById('dDay');

  const today = new Date();
  const thisYear = today.getFullYear();
  const thisMonth = today.getMonth() + 1;
  const thisDay = today.getDate();

  let daysOfYear= [31, countDaysOfFeb(thisYear), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

  monthBox.addEventListener('change', (e) => {
        dayBox.innerHTML = '';
        const selectedMonth = e.target.value;
        createOption('dDay', 1, daysOfYear[selectedMonth - 1], 1);
    });

    yearBox.addEventListener('change', e => {
        monthBox.innerHTML = '';
        dayBox.innerHTML = '';
        const updatedYear = e.target.value;
        daysOfYear = [31, countDaysOfFeb(updatedYear), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        createOption('dMonth', 1, 12, 1);
        createOption('dDay', 1, daysOfYear[0], 1);
    });

    createOption('dYear', thisYear, thisYear + 1, thisYear);
    createOption('dMonth', 1, 12, thisMonth);
    createOption('dDay', 1, daysOfYear[thisMonth - 1], thisDay);
})();

$('.p-create-form').on('submit', (e) => {
    const title = $('#title').val();
    const place = $('#place').val();
    const address = $('#address').val();
    const expense = $('#expense').val();
    const date_time = ($('#year').val() + '/' + $('#month').val() + '/' + $('#day').val() + ' ' + $('#from_hour').val() + ':' + $('#from_minute').val());
    const date_time_to = ($('#year').val() + '/' + $('#month').val() + '/' + $('#day').val() + ' ' + $('#to_hour').val() + ':' + $('#to_minute').val());
    const deadline = ($('#dYear').val() + '/' + $('#dMonth').val() + '/' + $('#dDay').val() + ' ' + $('#dHour').val() + ':' + $('#dMinute').val());
    const date = new Date(date_time);
    const date_to = new Date(date_time_to);
    const dDate = new Date(deadline);

    if(date >= date_to) {
        e.preventDefault();

        $('.remove-error-date_time').remove();

        $('<div class="error-target remove-error-date_time">終了時間は開催時間より後の時間で設定してください。</div>').insertAfter('#date_time-error');
    } else {
        $('.remove-error-date_time').remove();
    }
    
    if(date <= dDate) {
        e.preventDefault();

        $('.remove-error-deadline').remove();

        $('<div class="error-target remove-error-deadline">応募締切は開催日時より前の日時で設定して下さい。</div>').insertAfter('#deadline-error');
    } else {
        $('.remove-error-deadline').remove();
    }

    if (title === '') {

        e.preventDefault();

        $('.remove-error-title').remove();

        $('<div class="error-target remove-error-title">タイトルを入力して下さい。</div>').insertAfter('#title-error');
    } else {
        $('.remove-error-title').remove();
    }

    if (place === '') {

        e.preventDefault();

        $('.remove-error-place').remove();

        $('<div class="error-target remove-error-place">場所を入力して下さい。</div>').insertAfter('#place-error');
    } else {
        $('.remove-error-place').remove();
    }

    if (address === '') {

        e.preventDefault();

        $('.remove-error-address').remove();

        $('<div class="error-target remove-error-address">住所を入力して下さい。</div>').insertAfter('#address-error');
    } else {
        $('.remove-error-address').remove();
    }

    if (expense === '') {

        e.preventDefault();

        $('.remove-error-expense').remove();

        $('<div class="error-target remove-error-expense">参加費用を入力して下さい。</div>').insertAfter('#expense-error');
    } else {
        $('.remove-error-expense').remove();
    }
});


