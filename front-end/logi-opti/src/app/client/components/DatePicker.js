"use client"
import React, { useState,useEffect } from 'react';
import DatePicker from 'react-datepicker';
import 'react-datepicker/dist/react-datepicker.css';
import startOfMonth from 'date-fns/startOfMonth';
import endOfMonth from 'date-fns/endOfMonth';
import isAfter from 'date-fns/isAfter';
import { ApiService } from "@/app/services/apiService";

const MyDatePicker = ({setDataFinal}) => {
  const api = new ApiService();
  const [selectedDate, setSelectedDate] = useState(null);
  const [selectedDateAPI, setSelectedDateAPI] = useState("");


  useEffect(() => {
    const fetchData = async () => {
      try {
        if (selectedDateAPI) {
          console.log(selectedDateAPI);
          const token = localStorage.getItem("token");
          const data = await api.get(`/api/statistics/getDaylyToTal/${selectedDateAPI}/day/trajet`, token);
          setDataFinal(data); 
        }
      } catch (error) {
        console.error("Erreur lors de la récupération des données :", error);
      }
    };
  
    fetchData();
  }, [selectedDate]);

  const handleDateChange = (date) => {
    const rawDate = new Date(date);
    const dateFinal = `${rawDate.getFullYear()}-${(rawDate.getMonth() + 1).toString().padStart(2, '0')}-${rawDate.getDate().toString().padStart(2, '0')}`;
    setSelectedDate(date);
    setSelectedDateAPI(dateFinal);
    
  };

  const currentDate = new Date();
  const firstDayOfCurrentMonth = startOfMonth(currentDate);
  const lastDayOfCurrentMonth = endOfMonth(currentDate);

  const handleKeyDown = (event) => {
    // Empêcher la modification manuelle du champ de saisie
    event.preventDefault();
  };

  return (
    <div className="flex items-center justify-center mt-8">
      <DatePicker
        selected={selectedDate}
        onChange={handleDateChange}
        dateFormat="dd/MM/yyyy"
        placeholderText="Sélectionner un jour"
        className="p-2 border border-gray-300 rounded-md"
        minDate={firstDayOfCurrentMonth}
        maxDate={lastDayOfCurrentMonth}
        filterDate={(date) =>
          isAfter(date, firstDayOfCurrentMonth) &&
          isAfter(lastDayOfCurrentMonth, date) ||
          date.getDate() === firstDayOfCurrentMonth.getDate()
        }
        onKeyDown={handleKeyDown} // Intercepter les événements de clavier
      />
    </div>
  );
};

export default MyDatePicker;