<template>
  <swiper
    :spaceBetween="30"
    :centeredSlides="true"
    :autoplay="{
      delay: 2500,
      disableOnInteraction: false,
    }"
    :pagination="{
      clickable: true,
    }"
    :navigation="false"
    :modules="modules"
    class="mySwiper max-w-full "
  >
    <swiper-slide><img src="https://get.pxhere.com/photo/bike-transport-vehicle-motorcycle-motorbike-speed-cuba-motor-vespa-sidecar-motorcycling-976944.jpg"></swiper-slide>
    <swiper-slide><img src="https://get.pxhere.com/photo/bike-transport-vehicle-motorcycle-motorbike-speed-cuba-motor-vespa-sidecar-motorcycling-976944.jpg"></swiper-slide>
    <swiper-slide><img src="https://get.pxhere.com/photo/bike-transport-vehicle-motorcycle-motorbike-speed-cuba-motor-vespa-sidecar-motorcycling-976944.jpg"></swiper-slide>
    <swiper-slide><img src="https://get.pxhere.com/photo/bike-transport-vehicle-motorcycle-motorbike-speed-cuba-motor-vespa-sidecar-motorcycling-976944.jpg"></swiper-slide>
    <swiper-slide><img src="https://get.pxhere.com/photo/bike-transport-vehicle-motorcycle-motorbike-speed-cuba-motor-vespa-sidecar-motorcycling-976944.jpg"></swiper-slide>
    <swiper-slide><img src="https://get.pxhere.com/photo/bike-transport-vehicle-motorcycle-motorbike-speed-cuba-motor-vespa-sidecar-motorcycling-976944.jpg"></swiper-slide>
    <swiper-slide><img src="https://get.pxhere.com/photo/bike-transport-vehicle-motorcycle-motorbike-speed-cuba-motor-vespa-sidecar-motorcycling-976944.jpg"></swiper-slide>
    <swiper-slide><img src="https://get.pxhere.com/photo/bike-transport-vehicle-motorcycle-motorbike-speed-cuba-motor-vespa-sidecar-motorcycling-976944.jpg"></swiper-slide>
    <swiper-slide><img src="https://get.pxhere.com/photo/bike-transport-vehicle-motorcycle-motorbike-speed-cuba-motor-vespa-sidecar-motorcycling-976944.jpg"></swiper-slide>

  </swiper>
</template>

<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';

const modules = [Autoplay, Pagination, Navigation];
</script>
