"use client";
import React, { useState,useEffect } from 'react';
import { ApiService } from "@/app/services/apiService";


const SelecteurTemps = ({temps,setDataFinal,reset}) => {

  const api = new ApiService();


  const [isOpen, setIsOpen] = useState(false);
  const [selectedMonth, setSelectedMonth] = useState(null);
  const [selectedYear, setSelectedYear] = useState(null);
  const [selectedMonthAPI, setSelectedMonthAPI] = useState("");



  useEffect(() => {
    const fetchData = async () => {
      try {
        if (selectedMonth != null  && selectedYear != null) {
          console.log(selectedMonth);
          console.log(selectedYear);

          const date = selectedYear + '-' + selectedMonthAPI + "-01"
          const token = localStorage.getItem("token");
          const data = await api.get(`/api/statistics/getDaylyToTal/${date}/month/trajet`, token);
          console.log(data)
          setDataFinal(data); 
        }

       if (selectedMonth == null  && selectedYear != null) {

          const date = selectedYear + '-12-01'
          const token = localStorage.getItem("token");
          const data = await api.get(`/api/statistics/getDaylyToTal/${date}/year/trajet`, token);
          console.log(data)
          setDataFinal(data); 
        }
      } catch (error) {
        console.error("Erreur lors de la récupération des données :", error);
      }
    };
  
    fetchData();
  }, [selectedMonth,selectedYear]);

  useEffect(() => {
      setSelectedYear(null)
  }, [reset]);
  

  const toggleDropdown = () => {
    setIsOpen(!isOpen);
  };

  const closeDropdown = () => {
    setIsOpen(false);
  };


  const transformerMois = (mois) => {
    const moisTransforme = {
      "January": "01",
      "February": "02",
      "March": "03",
      "April": "04",
      "May": "05",
      "June": "06",
      "July": "07",
      "August": "08",
      "September": "09",
      "October": "10",
      "November": "11",
      "December": "12",
    };
  
    return moisTransforme[mois] || mois;
  };


  const handleMonthChange = (event) => {
    const selectedValue = event.target.value;
    setSelectedMonth(selectedValue);
    const mois = transformerMois(selectedValue)
    setSelectedMonthAPI(mois);
    closeDropdown();
  };

  const handleYearChange = (event) => {
    console.log("changer");
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