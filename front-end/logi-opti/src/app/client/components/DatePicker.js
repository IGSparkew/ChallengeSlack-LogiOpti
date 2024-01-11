"use client"
import React, { useState } from 'react';
import DatePicker from 'react-datepicker';
import 'react-datepicker/dist/react-datepicker.css';
import startOfMonth from 'date-fns/startOfMonth';
import endOfMonth from 'date-fns/endOfMonth';
import isAfter from 'date-fns/isAfter';

const MyDatePicker = () => {
  const [selectedDate, setSelectedDate] = useState(null);

  const handleDateChange = (date) => {
    setSelectedDate(date);
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