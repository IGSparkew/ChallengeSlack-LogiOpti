"use client";
import React, { useState, useEffect } from "react";
import { ApiService } from "@/app/services/apiService";

const ListeCamion = ({ setSelectedTruck }) => {
  const api = new ApiService();

  const [selectedCamion, setSelectedCamion] = useState(null);
  const [isOpen, setIsOpen] = useState(false);
  const [camions, setCamions] = useState([]);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const token = localStorage.getItem("token");
        console.log(token);
        const data = await api.get(`/api/vehicle/get`, token);
        setCamions(data);
        // setDataGlobal(data[0]["cout_totaux"]);
        // console.log(data[0]["cout_totaux"]);

        // console.log("Temps dans page.js : ", selectedTemps);
      } catch (error) {
        console.error("Erreur lors de la récupération des données :", error);
        // Gérer les erreurs ici
      }
    };

    fetchData();
  }, []);

  const toggleDropdown = () => {
    setIsOpen(!isOpen);
  };

  const closeDropdown = () => {
    setIsOpen(false);
  };

  const handleCamionChange = (event) => {
    const selectedValue = event.target.value;
    setSelectedCamion(selectedValue);
    setSelectedTruck(selectedValue);
    closeDropdown();
  };

  return (
    <div className="w-full flex justify-center mt-10 gap-5">
      <div className="relative inline-block text-left w-1/12">
        <select
          className="text-redFull block px-3 py-2 text-sm w-full text-left focus:outline-none bg-white border-2 border-redFull rounded w-full"
          onChange={handleCamionChange}
          value={selectedCamion || ""}
        >
          <option value="" disabled>
            Type de vehicule
          </option>
          {camions.map((camion, index) => (
            <option key={index} value={camion.vehicleType.type}>
              {camion.vehicleType.type}
            </option>
          ))}
        </select>
      </div>
    </div>
  );
};

export default ListeCamion;