<script setup>
    import {onMounted} from 'vue';
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

    onMounted(() => {
        let date = new Date();
        let year = date.getFullYear();
        let month = date.getMonth();
        const day = document.querySelector(".calendar-dates");

        const currdate = document
            .querySelector(".calendar-current-date");

        const prenexIcons = document
            .querySelectorAll(".calendar-navigation span");

        const months = [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ];

        const manipulate = () => {
            const daysWithEvents = postsDates();
            let dayone = new Date(year, month, 1).getDay();
            let lastdate = new Date(year, month + 1, 0).getDate();
            let dayend = new Date(year, month, lastdate).getDay();
            let monthlastdate = new Date(year, month, 0).getDate();

            let cell = "";
            for (let i = dayone; i > 0; i--) {
                if (month + 1)
                    cell += `<a class="inactive">${monthlastdate-i+1}</a>`;
            }

            for (let i = 1; i <= lastdate; i++) {
                let isToday = (i === date.getDate() && month === new Date().getMonth() && year === new Date().getFullYear())
                let today = "";
                if(isToday) {
                    today = "active";
                }

                //console.log(postsDates())
                let hasEvent = daysWithEvents.includes(`${month+1}/${i}/${year}`);
                let event = ""
                if(hasEvent) {
                    event = 'with_event';
                } 

                let posts_found = ""
                if (hasEvent) {
                    posts_found = postsPerDate(`${month+1}/${i}/${year}`);
                }

                cell += `<a class="${event} ${today}" title="${(posts_found != "") ? posts_found[0].title : "No hay eventos en esta fecha"}" href="${(posts_found != "") ? '/post/' + posts_found[0].id : ""}" >${i}</a>`;
            }

            for (let i = dayend; i < 6; i++) {
                cell += `<a class="inactive">${i-dayend+1}</a>`
            }

            currdate.innerText = `${months[month]} ${year}`;
            day.innerHTML = cell;
        }

        manipulate();

        prenexIcons.forEach(icon => {
            icon.addEventListener("click", () => {
                month = icon.id === "calendar-prev" ? month - 1 : month + 1;

                if (month < 0 || month > 11) {
                    date = new Date(year, month, new Date().getDate());
                    year = date.getFullYear();
                    month = date.getMonth();
                } else {
                    date = new Date();
                }

                manipulate();
            });
        });
    })
</script>
<template>
    <div class=" flex justify-end items-center mb-3  ">
        <div class="card-body events-calendar xl:w-[450px] sm:w-[400px] sm:p-0">
            <h5 class="card-title">{{ title }}</h5>
            <p class="card-text">{{ desc }}</p>
            <div class="calendar-container">
                <header class="calendar-header">
                    <p class="calendar-current-date"></p>
                    <div class="calendar-navigation">
                        <span id="calendar-prev" class="material-symbols-rounded">
                            <img :src="ForwardSVG" />
                        </span>
                        <span id="calendar-next" class="material-symbols-rounded">
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
                    <ul id="calendarDates" class="calendar-dates"></ul>
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

    .calendar-body a {
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