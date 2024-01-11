"use client";
import React, { useState } from 'react';

const SelecteurTemps = ({temps}) => {
  const [isOpen, setIsOpen] = useState(false);
  const [selectedMonth, setSelectedMonth] = useState(null);
  const [selectedYear, setSelectedYear] = useState(null);

  const toggleDropdown = () => {
    setIsOpen(!isOpen);
  };

  const closeDropdown = () => {
    setIsOpen(false);
  };

  const handleMonthChange = (event) => {
    const selectedValue = event.target.value;
    setSelectedMonth(selectedValue);
    closeDropdown();
  };

  const handleYearChange = (event) => {
    const selectedValue = event.target.value;
    setSelectedYear(selectedValue);
    closeDropdown();
  };

  // Générer les options pour tous les mois de l'année
  const months = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
  ];

  const years = [
    '2010', '2011', '2012', '2013', '2014', '2015',
    '2016', '2017', '2018', '2019', '2020', '2021','2022', '2023', '2024'
  ];

  return (
    <div className='w-full flex justify-center mt-10 gap-5'>
        {temps == "month" && (
            <div className="relative inline-block text-left w-2/12">
                <select
                className="text-redFull block px-3 py-2 text-sm w-full text-left focus:outline-none bg-white border-2 border-redFull rounded w-full"
                onChange={handleMonthChange}
                value={selectedMonth || ''}
                >
                <option value="" disabled>Mois</option>
                {months.map((month, index) => (
                    <option key={index} value={month}>{month}</option>
                ))}
                </select>
            </div>
        )}
      
      <div className="relative inline-block text-left w-1/12">
        <select
          className="text-redFull block px-3 py-2 text-sm w-full text-left focus:outline-none bg-white border-2 border-redFull rounded w-full"
          onChange={handleYearChange}
          value={selectedYear || ''}
        >
          <option value="" disabled>Annee</option>
          {years.map((year, index) => (
            <option key={index} value={year}>{year}</option>
          ))}
        </select>
      </div>
    </div>
  );
};

export default SelecteurTemps;