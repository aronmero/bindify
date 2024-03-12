<script setup>
    import {onMounted, ref} from 'vue';
    import ForwardSVG from '@public/assets/icons/forward.svg';
    import {comparar_fechas} from '@/components/calendario/helpers/comparar_fechas.js';
    
    /* realizado por David */

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
        const lastDate = new Date(year.value, month.value + 1, 0).getDate();
        const firstDay = new Date(year.value, month.value, 1).getDay();
        const monthLabel = `${months[month.value]} ${year.value}`;
        currentMonth.value = monthLabel;

        const newDays = [];
        const prevMonthLastDate = new Date(year.value, month.value, 0).getDate();

        // Agregar días inactivos del mes anterior
        for (let i = firstDay - 1; i >= 0; i--) {
            newDays.push({ day: prevMonthLastDate - i, month: month.value + 1, year: year.value, inactive: true });
        }

        // Agregar días activos del mes actual
        for (let i = 1; i <= lastDate; i++) {
            newDays.push({ day: i,  month: month.value + 1, year: year.value, inactive: false });
        }

        // Agregar días inactivos del mes siguiente
        const daysToAdd = 6 - newDays.length % 7;
        for (let i = 1; i <= daysToAdd; i++) {
            newDays.push({ day: i, month: month.value + 1, year: year.value,  inactive: true });
        }

        days.value = newDays;
    };

    const cambiarFecha = (day) => {
      // Formatear la fecha con el mismo de sql
      let fechaElegida = `${day.year}-${day.day}-${day.month}`;

      // Obtiene el id del título y nos muestra la fecha actual
      document.getElementById("fecha").innerHTML = `Martes, ${day.day} de ${months[day.month]} de ${day.year}`

      let cards = Array.from(document.getElementsByClassName('card'));
      // Filtra las fechas comparándolas
      cards.forEach(card => {
        console.log(`comparando ${fechaElegida} - ${card.dataset.start_date}`)
        if(comparar_fechas(card.dataset.start_date, fechaElegida, card.dataset.end_date)) card.style.display = "flex";
        else card.style.display = "none";
      })

      console.log(day);

      
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
                <li v-for="day in days" :key="day" :class="(day.inactive) ? 'inactive':'active'">
                  <button @click="cambiarFecha(day)">{{ day.day }}</button>
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
        justify-content: flex-start;
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

    .calendar-body .active button {
        //color: red !important;
    }



    .calendar-body .with_event {
        background: #f3f3f3;
        cursor: pointer;
    }

    .calendar-body .inactive button {
        color: #BFC1C5 !important;
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