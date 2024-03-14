<script setup>
    import {onMounted, ref} from 'vue';
    import { postsPerDate, postsDates, format_date } from '../mocks/filtros';
    import ForwardSVG from '@public/assets/icons/forward.svg';
    

    const props = defineProps({
        title: String, 
        desc: String, 
        type: String,
        posts: Array, 
        dates: Array,
        post_per_date: Function
    });

    const year = ref(new Date().getFullYear());
    const month = ref(new Date().getMonth());

    const months = [
      "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
      "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];

    const currentMonth = ref('');

    const days = ref([]);

    const manipulate = () => {
      const dayOne = new Date(year, month, 1).getDay();
      
      const lastDate = new Date(year.value, month.value + 1, 0).getDate();
      let dayEnd = new Date(year, month, lastDate).getDay();
      const monthLabel = `${months[month.value]} ${year.value}`;
      currentMonth.value = monthLabel;

      const newDays = [];

      for (let i = dayOne; i > 0; i--) {
            if (month + 1) newDays.push(i);
      }
      for (let i = 1; i <= lastDate; i++) {
        newDays.push(i);
      }

      for (let i = dayEnd; i < 6; i++) {
        newDays.push(i);
                //cell += `<button class="inactive">${i-dayend+1}</button>`
        }


      days.value = newDays;
    };

    const cambiarFecha = (test, day) => {
      console.log(test, day);
    };

    const getButtonClasses = (day) => {
      const isToday = day === new Date().getDate() && month.value === new Date().getMonth() && year.value === new Date().getFullYear();
      // Add your logic for getting classes based on events
      return [isToday ? 'active' : ''].join(' ');
    };

    const changeMonth = (diff) => {
      month.value += diff;
      if (month.value < 0 || month.value > 11) {
        const currentDate = new Date(year.value, month.value, new Date().getDate());
        year.value = currentDate.getFullYear();
        month.value = currentDate.getMonth();
    }
    manipulate();
};

onMounted(() => {
  manipulate();
});

</script>

<template>
    <div class="flex justify-end items-center mb-3">
        <div class="card-body events-calendar xl:w-[450px] sm:w-[400px] sm:p-0">
          <h5 class="card-title">{{ title }}</h5>
          <p class="card-text">{{ desc }}</p>
          <div class="calendar-container">
            <header class="calendar-header">
              <p class="calendar-current-date">{{ currentMonth }}</p>
              <div class="calendar-navigation">
                <span id="calendar-prev" @click="changeMonth(-1)" class="material-symbols-rounded">
                  <img :src="ForwardSVG" />
                </span>
                <span id="calendar-next" @click="changeMonth(1)" class="material-symbols-rounded">
                  <img :src="ForwardSVG" />
                </span>
              </div>
            </header>
            <div class="calendar-body">
              <ul class="calendar-weekdays">
                <li>Dom</li>
                <li>Lun</li>
                <li>Mar</li>
                <li>Mie</li>
                <li>Jue</li>
                <li>Vie</li>
                <li>Sab</li>
              </ul>
              <ul id="calendarDates" class="calendar-dates">
                <li v-for="day in days" :key="day" :class="getButtonClasses(day)">
                  <button @click="cambiarFecha('test', day)">{{ day }}</button>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
</template>
<style lang="scss">
    @import './../styles/calendario/variables', './../styles/calendario/mixins';

    .calendar-container {
        margin:20px 0px;
        width:100%;
        height:450px;
        padding:20px;
        border-radius: 10px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
    }

    .calendar-container header {
        display: flex;
        align-items: center;
        padding: 25px 30px 10px;
        justify-content: space-between;
        //background:red;
        
    }

    header .calendar-navigation {
        @include row_center();
    }

    header .calendar-navigation span {
        @include row_center();
        height: 38px;
        width: 38px;
        margin: 0 1px;
        cursor: pointer;
        text-align: center;
        line-height: 30px;
        border-radius: 50%;
        user-select: none;
        color: #aeabab;
        font-size: 1.8rem;
    }

    .calendar-navigation span:last-child {
        margin-right: -10px;
    }

    header .calendar-navigation span:hover {
        background: #f2f2f2;
    }

    header .calendar-current-date {
        font-weight: 500;
        font-size:1.2rem;
    }

    .calendar-body {
        padding: 20px;
    }

    .calendar-body ul {
        @include row_center();
        list-style: none;
        flex-wrap: wrap;
        padding: 0;
    }

    .calendar-body .calendar-dates {
        margin-bottom: 20px;
    }

    .calendar-body button {
        text-decoration: none;
        width: calc(100% / 7);
        font-size: 1.07rem;
        font-size:.9rem;
        color: #414141;
        padding:10px;
    }

    .calendar-body li {
        text-decoration: none;
        font-size:.9rem;
        width: calc(100% / 7);
        font-size: .9rem;
        color: #414141;
    }

    .calendar-body .calendar-weekdays li {
        cursor: default;
        font-weight: 500;
        font-size:.9rem;
    }

    .calendar-body .active {
        color: red;
    }

    .calendar-body .with_event {
        background: #f3f3f3;
        cursor: pointer;
    }

    .calendar-body .inactive {
        color: #BFC1C5;
    }

    #calendar-prev {
        // transform: rotate(180deg);
    }

    #calendar-next {
        transform: rotate(180deg);
    }

    @media screen and (max-width: 640px) {
        .calendar-container {
            padding:0px 10px;
            height:350px;
            margin-top:0px;
            .calendar-body {
                padding:10px;
            }
            header {
                padding:5px 10px;
                .calendar-current-date {
                    font-size:.9rem;
                }
            }
            .events-calendar {
                max-width:100%;
                a {
                    padding:7px 0px;
                    font-size:.7rem;
                }
            }   
        }
        .card {
            padding:5px 10px;
        }
       
    }
</style>