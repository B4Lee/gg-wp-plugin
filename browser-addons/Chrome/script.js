async function fetchData() {
    const res=await fetch ("https://covid19.mathdro.id/api/countries/IDN");
    const record=await res.json();
    document.getElementById("date").innerHTML=record.lastUpdate;
    document.getElementById("latestBy").innerHTML=record.confirmed.value;
    document.getElementById("deathNew").innerHTML=record.deaths.value;

    console.log(record);
}

fetchData();