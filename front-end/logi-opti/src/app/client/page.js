'use client'
import Header from "../components/Header";
import Sidebar from "../components/Sidebar";
import TopCards from "../components/TopCards";
import Table from '../components/table'
import MyDatePicker from "./components/DatePicker";
import SelecteurTemps from "./components/SelecteurTemps";
import Temps from "./components/Temps";
import { data1 } from '../data/data1';
import { data2 } from '../data/data2';
import { data3} from '../data/data3';
import { data4} from '../data/data4';
import { data5} from '../data/data5';
import { data6} from '../data/data6';
import React, { useState,useEffect } from 'react';
import ListeCamion from "./components/ListeCamion";

import { ApiService } from "@/app/services/apiService";


export default function Client() {

    const api = new ApiService();

    const [selectedTemps, setSelectedTemps] = useState("day");
    const [dataFinal, setDataFinal] = useState(data1);
    const [dataGlobal,setDataGlobal] = useState([]);
    const [selectedMoyen,setSelectedMoyen] =useState("trajet");
    const [reset,setReset] = useState(false);
    const [selectedTruck, setSelectedTruck] = useState("");




    useEffect(() => {
        const fetchData = async () => {
          try {
            if (selectedTemps === "day") {
              const currentDateObj = new Date();
              const isoDateString = currentDateObj.toISOString();
              const formattedDate = isoDateString.slice(0, 10);
    
              const token = localStorage.getItem("token");
              const data = await api.get(`/api/statistics/getDaylyToTal/${formattedDate}/day/trajet`, token);
              setDataFinal(data[0]["livraisons"]);
              setDataGlobal(data[0]["cout_totaux"]);
              console.log(data[0]["cout_totaux"]);
            } else if (selectedTemps === "month") {
              setDataFinal([]);
            } else if (selectedTemps === "year") {
              setDataFinal([]);
            } else if (selectedTemps === "dayCamion") {
                const currentDateObj = new Date();
                const isoDateString = currentDateObj.toISOString();
                const formattedDate = isoDateString.slice(0, 10);

                const token = localStorage.getItem("token");
                const data = await api.get(
                    `/api/statistics/getDaylyToTal/${formattedDate}/day/truck/${selectedTruck}`,
                    token
                );
                console.log(data);
                setDataFinal(data[0]["livraisons"]);
                setDataGlobal(data[0]["cout_totaux"]);
            } else if (selectedTemps === "monthCamion") {
                const currentDateObj = new Date();
                const isoDateString = currentDateObj.toISOString();
                const formattedDate = isoDateString.slice(0, 10);

                const token = localStorage.getItem("token");
                const data = await api.get(
                    `/api/statistics/getDaylyToTal/${formattedDate}/month/truck/${selectedTruck}`,
                    token
                );
                console.log(data);
                setDataFinal(data[0]["livraisons"]);
                setDataGlobal(data[0]["cout_totaux"]);
            } else {
                const currentDateObj = new Date();
                const isoDateString = currentDateObj.toISOString();
                const formattedDate = isoDateString.slice(0, 10);

                const token = localStorage.getItem("token");
                const data = await api.get(
                    `/api/statistics/getDaylyToTal/${formattedDate}/year/truck/${selectedTruck}`,
                    token
                );
                console.log(data);
                setDataFinal(data[0]["livraisons"]);
                setDataGlobal(data[0]["cout_totaux"]);
            }
    
            console.log("Temps dans page.js : ", selectedTemps);
          } catch (error) {
            console.error("Erreur lors de la récupération des données :", error);
            // Gérer les erreurs ici
          }
        };
    
        fetchData();
      }, [selectedTemps,selectedTruck]);
    
      useEffect(() => {
        // Effectuez des actions si nécessaire lors de la modification de selectedMoyen
      }, [selectedMoyen]);


    const handleSelectedTemps = (data) => {
        console.log("dans la fonction handleSelectedTemps");
        console.log(data);
        setSelectedTemps(data)
    }

    const handleReset = (data) => {
        setReset(data);
        console.log(reset);
    }

    const handleSelectedMoyen = (data) => {
        console.log("dans la fonction handleSelectedMoyen");
        console.log(data);
        setSelectedMoyen(data)
    }

    const handleSetDataFinal = (data) => {
        console.log("data", data);
        setDataFinal(data[0]["livraisons"])
        setDataGlobal(data[0]["cout_totaux"])
    }

    const handleSelectedTruck = (data) => {
        setSelectedTruck(data);
      };

    const conditionTime = selectedTemps === "month" || selectedTemps === "year";

    return (
        <main className="flex ">

            <Sidebar />
            <div className="flex-auto" >
                <Header />
                <TopCards dataGlobal={dataGlobal}/>
                <Temps setSelectedTemps={handleSelectedTemps} setSelectedMoyen={setSelectedMoyen} selectedMoyen={selectedMoyen} selectedTemps={selectedTemps} setReset={handleReset} reset={reset}/>
                {(() => {
                        if (selectedTemps === "day") {
                            return <MyDatePicker setDataFinal={handleSetDataFinal}  />;
                        } else if (selectedTemps === "dayCamion") {
                            return (
                            <>
                                <MyDatePicker setDataFinal={handleSetDataFinal}  />
                                <ListeCamion setSelectedTruck={handleSelectedTruck} />
                            </>
                            );
                        } else if (conditionTime) {
                            return <SelecteurTemps temps={selectedTemps} setDataFinal={handleSetDataFinal} reset={reset}/>;
                        } else if (selectedTemps == "monthCamion") {
                            return (
                            <>
                                <SelecteurTemps temps={"month"} setDataFinal={handleSetDataFinal} reset={reset}/>
                                <ListeCamion setSelectedTruck={handleSelectedTruck} />
                            </>
                            );
                        } else if (selectedTemps == "yearCamion") {
                            return (
                            <>
                                <SelecteurTemps temps={"year"} setDataFinal={handleSetDataFinal} reset={reset}/>
                                <ListeCamion setSelectedTruck={handleSelectedTruck} />
                            </>
                            );
                        }
                    })()}
               
                <Table  data ={dataFinal} setSelectedMoyen={handleSelectedMoyen} setSelectedTemps={handleSelectedTemps} selectedTemps={selectedTemps}/>

                

            </div>

        </main>
    );
}
