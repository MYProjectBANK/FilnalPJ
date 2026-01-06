<template>
  <!-- WIFI -->
  <svg v-if="type === 'wifi'" :class="iconClass" viewBox="0 0 24 24" fill="none">
    <path d="M2 8.5C7.5 3.5 16.5 3.5 22 8.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M5 12c4-3.5 10-3.5 14 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M8.5 15.5c2-1.8 5-1.8 7 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M12 19h.01" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
  </svg>

  <!-- AIR CONDITIONER -->
  <svg v-else-if="type === 'aircon'" :class="iconClass" viewBox="0 0 24 24" fill="none">
    <path d="M4 6h16a2 2 0 0 1 2 2v2H2V8a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="2"/>
    <path d="M6 14c0 3 3 3 3 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M12 14c0 3 3 3 3 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M18 14c0 3-3 3-3 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  </svg>

  <!-- WATER HEATER (shower) -->
  <svg v-else-if="type === 'water_heater'" :class="iconClass" viewBox="0 0 24 24" fill="none">
    <path d="M7 5h6a4 4 0 0 1 4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M9 5V3h4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M6 11h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M9 14l0 0M12 14l0 0M15 14l0 0" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
    <path d="M10 18c0 1 1 2 2 2s2-1 2-2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  </svg>

  <!-- FURNITURE (chair) -->
  <svg v-else-if="type === 'furniture'" :class="iconClass" viewBox="0 0 24 24" fill="none">
    <path d="M7 11a5 5 0 0 1 10 0v4H7v-4Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
    <path d="M6 15v5M18 15v5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M8 10V7a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  </svg>

  <!-- KEYCARD (card) -->
  <svg v-else-if="type === 'keycard'" :class="iconClass" viewBox="0 0 24 24" fill="none">
    <path d="M4 7a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V7Z" stroke="currentColor" stroke-width="2"/>
    <path d="M7 9h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M7 13h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M16 13h1" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  </svg>

  <!-- ELEVATOR -->
  <svg v-else-if="type === 'elevator'" :class="iconClass" viewBox="0 0 24 24" fill="none">
    <path d="M6 2h12v20H6V2Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
    <path d="M10 7l2-2 2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M14 17l-2 2-2-2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M9 11h6v4H9v-4Z" stroke="currentColor" stroke-width="2"/>
  </svg>

  <!-- CCTV -->
  <svg v-else-if="type === 'cctv'" :class="iconClass" viewBox="0 0 24 24" fill="none">
    <path d="M3 9l10-4 8 4-10 4-8-4Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
    <path d="M11 13v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M7 21h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M18 9l2 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  </svg>

  <!-- GYM -->
  <svg v-else-if="type === 'gym'" :class="iconClass" viewBox="0 0 24 24" fill="none">
    <path d="M6 9v6M18 9v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M8 8v8M16 8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M10 12h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M3 10v4M21 10v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  </svg>

  <!-- LAUNDRY / LAUNDROMAT -->
  <svg v-else-if="type === 'laundry'" :class="iconClass" viewBox="0 0 24 24" fill="none">
    <path d="M6 3h12v18H6V3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
    <path d="M9 7h.01M12 7h.01M15 7h.01" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
    <path d="M12 18a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z" stroke="currentColor" stroke-width="2"/>
    <path d="M9.5 14.5c1.2 1 3.8 1 5 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  </svg>

  <!-- PARKING (car) -->
  <svg v-else-if="type === 'parking'" :class="iconClass" viewBox="0 0 24 24" fill="none">
    <path d="M7 3h6a5 5 0 0 1 0 10H7V3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
    <path d="M7 13v8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M4 3h16v18H4V3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
  </svg>

  <!-- MOTORCYCLE PARKING -->
  <svg v-else-if="type === 'motorcycle_parking'" :class="iconClass" viewBox="0 0 24 24" fill="none">
    <path d="M6 16a3 3 0 1 0 0 .01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M18 16a3 3 0 1 0 0 .01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M10 16h4l-2-5h-3l-2 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M13 11h3l2-3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  </svg>

  <!-- SECURITY (shield) -->
  <svg v-else-if="type === 'security'" :class="iconClass" viewBox="0 0 24 24" fill="none">
    <path d="M12 2l8 4v7c0 5-3.5 9-8 9s-8-4-8-9V6l8-4Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
    <path d="M9 12l2 2 4-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  </svg>

  <!-- WATER DISPENSER -->
  <svg v-else-if="type === 'water_dispenser'" :class="iconClass" viewBox="0 0 24 24" fill="none">
    <path d="M8 2h8v6H8V2Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
    <path d="M7 8h10v14H7V8Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
    <path d="M10 12h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M12 12v3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M11 19h2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  </svg>

  <!-- BALCONY -->
  <svg v-else-if="type === 'balcony'" :class="iconClass" viewBox="0 0 24 24" fill="none">
    <path d="M5 4h14v8H5V4Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
    <path d="M4 12h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M7 12v8M12 12v8M17 12v8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M4 20h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  </svg>

  <!-- FRIDGE -->
  <svg v-else-if="type === 'fridge'" :class="iconClass" viewBox="0 0 24 24" fill="none">
    <path d="M7 2h10v20H7V2Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
    <path d="M7 12h10" stroke="currentColor" stroke-width="2"/>
    <path d="M9 6h.01M9 16h.01" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
  </svg>

  <!-- PRIVATE BATHROOM -->
  <svg v-else-if="type === 'private_bathroom'" :class="iconClass" viewBox="0 0 24 24" fill="none">
    <path d="M7 10a5 5 0 0 1 10 0v5a4 4 0 0 1-4 4H11a4 4 0 0 1-4-4v-5Z" stroke="currentColor" stroke-width="2"/>
    <path d="M9 10V7a3 3 0 0 1 6 0v3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M7 15h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  </svg>

  <!-- PARCEL POINT -->
  <svg v-else-if="type === 'parcel'" :class="iconClass" viewBox="0 0 24 24" fill="none">
    <path d="M4 7l8-4 8 4v10l-8 4-8-4V7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
    <path d="M4 7l8 4 8-4" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
    <path d="M12 11v10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M9 9l6-3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  </svg>

  <!-- LOBBY -->
  <svg v-else-if="type === 'lobby'" :class="iconClass" viewBox="0 0 24 24" fill="none">
    <path d="M4 10l8-6 8 6v10H4V10Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
    <path d="M9 20v-6h6v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M7 12h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  </svg>

  <!-- MICROWAVE -->
  <svg v-else-if="type === 'microwave'" :class="iconClass" viewBox="0 0 24 24" fill="none">
    <path d="M3 7h18v10H3V7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
    <path d="M6 10h8v4H6v-4Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
    <path d="M17 10h.01M17 13h.01" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
  </svg>

  <!-- DEFAULT -->
  <svg v-else :class="iconClass" viewBox="0 0 24 24" fill="none">
    <path d="M12 2l3 7 7 3-7 3-3 7-3-7-7-3 7-3 3-7Z"
          stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
  </svg>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  name: { type: String, default: "" }, // name จาก DB เช่น "Wi-Fi", "ที่จอดรถ"
  class: { type: String, default: "" },
});

const iconClass = computed(() => props.class || "w-5 h-5");

const type = computed(() => {
  const n = (props.name || "").toLowerCase().trim();

  // Wi-Fi
  if (n.includes("wifi") || n.includes("wi-fi") || n.includes("ไวไฟ") || n.includes("อินเทอร์เน็ต")) return "wifi";

  // Aircon
  if (n.includes("แอร์") || n.includes("air")) return "aircon";

  // Water heater
  if (n.includes("เครื่องทำน้ำอุ่น") || n.includes("water heater") || n.includes("heater")) return "water_heater";

  // Furniture
  if (n.includes("เฟอร์นิเจอร์") || n.includes("furniture") || n.includes("fully furnished")) return "furniture";

  // Keycard
  if (n.includes("คีย์การ์ด") || n.includes("key card") || n.includes("keycard")) return "keycard";

  // Elevator
  if (n.includes("ลิฟต์") || n.includes("elevator")) return "elevator";

  // CCTV
  if (n.includes("กล้องวงจรปิด") || n.includes("cctv")) return "cctv";

  // Gym
  if (n.includes("ฟิตเนส") || n.includes("gym")) return "gym";

  // Laundry
  if (n.includes("ร้านซักอบรีด") || n.includes("ซักอบรีด") || n.includes("laundry") || n.includes("laundromat")) return "laundry";

  // Parking car
  if (n.includes("ที่จอดรถ") || n.includes("parking") || n.includes("car park")) return "parking";

  // Motorcycle parking
  if (n.includes("จอดมอเตอร์ไซค์") || n.includes("motorcycle") || n.includes("bike parking")) return "motorcycle_parking";

  // Security guard
  if (n.includes("รปภ") || n.includes("security")) return "security";

  // Water dispenser
  if (n.includes("ตู้กดน้ำ") || n.includes("water dispenser") || n.includes("dispenser")) return "water_dispenser";

  // Balcony
  if (n.includes("ระเบียง") || n.includes("balcony")) return "balcony";

  // Fridge
  if (n.includes("ตู้เย็น") || n.includes("fridge") || n.includes("refrigerator")) return "fridge";

  // Private bathroom
  if (n.includes("ห้องน้ำในตัว") || n.includes("private bathroom") || n.includes("ensuite")) return "private_bathroom";

  // Parcel point
  if (n.includes("พัสดุ") || n.includes("parcel") || n.includes("delivery")) return "parcel";

  // Lobby
  if (n.includes("ล็อบบี้") || n.includes("lobby")) return "lobby";

  // Microwave
  if (n.includes("ไมโครเวฟ") || n.includes("microwave")) return "microwave";

  return "default";
});
</script>
