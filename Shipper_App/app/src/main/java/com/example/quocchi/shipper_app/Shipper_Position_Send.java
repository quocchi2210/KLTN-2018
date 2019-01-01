package com.example.quocchi.shipper_app;

import android.Manifest;
import android.content.Context;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Bundle;
import android.support.v4.app.ActivityCompat;
import android.util.Log;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.concurrent.ScheduledFuture;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.CertificatePinner;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class Shipper_Position_Send implements LocationListener {

    private String latitude;
    private String longitude;


    private static LocationManager locationManager;
    private Context mContext;

    private static Shipper_Position_Send obj;

    private String hostname = "luxexpress.cf";

    //    private static boolean update_check = false;
    //public int position_index = -1;
    String token = Login_Token.token;

    CertificatePinner certificatePinner = new CertificatePinner.Builder()
            .add(hostname, "sha256/MPTkwqvsxxFu44jSBUkloPwzP8VQwYEaGybVkEmRuww=")
            .add(hostname, "sha256/YLh1dUR9y6Kja30RrAn7JKnbQG/uEtLMkBgFF2Fuihg=")
            .add(hostname, "sha256/Vjs8r4z+80wjNcr1YKepWQboSIRi63WsWXhIMN+eWys=")
            .build();

    OkHttpClient client = new OkHttpClient.Builder()
            .certificatePinner(certificatePinner)
            .build();

    ScheduledFuture<?> t;

    private Shipper_Position_Send() {

        RequestBody requestBody = new MultipartBody.Builder()
                .setType(MultipartBody.FORM)
                .addFormDataPart("input", "input")
                .build();

        Request request = new Request.Builder()
                //.url("http://192.168.0.132:8000/api/shipper/getDirection")
                .url("https://luxexpress.cf/api/ordertrakings/updatePosition")
                .post(requestBody)
                .addHeader("Authorization", "Bearer " + token)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                e.printStackTrace();
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                final String yourResponse = response.body().string();

                if (response.isSuccessful()) {


                    JSONObject Jobject = null;
                    try {

                        Jobject = new JSONObject(yourResponse);
                        String data = Jobject.getString("data");
                        if(!data.contains("true")){
                            if(Integer.parseInt(data)>0){
                                Login_Token.update_check = true;
                            }
                        }


                    } catch (JSONException e) {
                        e.printStackTrace();
                    }


                } else {
                    Log.w("test map", yourResponse.toString());
                }


            }
        });
    }

    public static Shipper_Position_Send getInstance() {
        if (obj == null) {
            obj = new Shipper_Position_Send();
        }
        return obj;
    }

    public void setMyContext(Context mContext) {
        this.mContext = mContext;

        locationManager = (LocationManager) mContext.getSystemService(Context.LOCATION_SERVICE);
        if (ActivityCompat.checkSelfPermission(mContext, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(mContext, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            return;
        }
        locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, 0, 0, this);

    }

    @Override
    public void onLocationChanged(Location location) {

        //Toast.makeText(mContext, "Ok: Location" + location.getLatitude(), Toast.LENGTH_SHORT).show();
        Log.w("wtf", String.valueOf(Login_Token.update_check));

        if(Login_Token.id_order!=null){
            Log.w("wtf",  Login_Token.id_order);
        }else{
            Log.w("wtf",  "Sax");
        }

        if(Login_Token.update_check==true) {
            Toast.makeText(mContext, "Ok: Location UPDATE TRUE", Toast.LENGTH_SHORT).show();
            RequestBody requestBody ;
            if(Login_Token.id_order!=null){
                requestBody = new MultipartBody.Builder()
                        .setType(MultipartBody.FORM)
                        //.addFormDataPart("origin",  "10.766090,106.642000")
                        //10.766080 106.652260
                        //.addFormDataPart("destination", "132E Cách Mạng Tháng Tám P10 Q3")
                        .addFormDataPart("lat", String.valueOf(location.getLatitude()))
                        .addFormDataPart("long", String.valueOf(location.getLongitude()))
                        .addFormDataPart("order_id", Login_Token.id_order)
                        .build();
            }else{
                requestBody = new MultipartBody.Builder()
                        .setType(MultipartBody.FORM)
                        //.addFormDataPart("origin",  "10.766090,106.642000")
                        //10.766080 106.652260
                        //.addFormDataPart("destination", "132E Cách Mạng Tháng Tám P10 Q3")
                        .addFormDataPart("lat", String.valueOf(location.getLatitude()))
                        .addFormDataPart("long", String.valueOf(location.getLongitude()))
                        .build();
            }


            Request request = new Request.Builder()
                    //.url("http://192.168.0.132:8000/api/shipper/getDirection")
                    .url("https://luxexpress.cf/api/ordertrakings/updatePosition")
                    .post(requestBody)
                    .addHeader("Authorization", "Bearer " + token)
                    .build();

            client.newCall(request).enqueue(new Callback() {
                @Override
                public void onFailure(Call call, IOException e) {
                    e.printStackTrace();
                }

                @Override
                public void onResponse(Call call, Response response) throws IOException {
                    final String yourResponse = response.body().string();

                    if (response.isSuccessful()) {


                        JSONObject Jobject = null;
                        try {

                            Jobject = new JSONObject(yourResponse);

                            //JSONArray Jarray = Jobject.getJSONArray("routes");
//                        List<MapsActivity.Route> List_lat_long = new ArrayList<MapsActivity.Route>();
//                        List_lat_long = parseJSon(yourResponse);
//                        showDirection(List_lat_long);
//                        Log.w("test map", List_lat_long.toString());

                        } catch (JSONException e) {
                            e.printStackTrace();
                        }


                    } else {
                        Log.w("test map", yourResponse.toString());
                    }


                }
            });
        }
        //t = executor.scheduleAtFixedRate(new MyTask(), 0, 2, TimeUnit.SECONDS);
    }

    @Override
    public void onStatusChanged(String provider, int status, Bundle extras) {

    }

    @Override
    public void onProviderEnabled(String provider) {

    }

    @Override
    public void onProviderDisabled(String provider) {

    }

    class MyTask implements Runnable {

        public void run() {
            send_lat_long();
        }
    }

//    public void set_check_update(boolean check_update){
//        this.update_check = check_update;
//    }
//
//    public boolean get_check_update(){
//        return this.update_check;
//    }


    public void send_lat_long() {

        if (ActivityCompat.checkSelfPermission(mContext, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(mContext, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            // TODO: Consider calling
            //    ActivityCompat#requestPermissions
            // here to request the missing permissions, and then overriding
            //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
            //                                          int[] grantResults)
            // to handle the case where the user grants the permission. See the documentation
            // for ActivityCompat#requestPermissions for more details.
            return;
        }
        locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, 0, 0, this);
        Location loc = locationManager.getLastKnownLocation(LocationManager.GPS_PROVIDER);

        if (loc != null && latitude == null && longitude == null) {
            Log.i("send_post", "Location: " + loc.toString());
            latitude = String.valueOf(loc.getLatitude());
            longitude = String.valueOf(loc.getLongitude());
        }


        Log.i("send_post", "origin_address: " + latitude + ", Longitude: " + longitude);

        //10.766080   //106.652260

        RequestBody requestBody = new MultipartBody.Builder()
                .setType(MultipartBody.FORM)
                //.addFormDataPart("origin",  "10.766090,106.642000")
                //10.766080 106.652260
                //.addFormDataPart("destination", "132E Cách Mạng Tháng Tám P10 Q3")
                .addFormDataPart("lat", latitude)
                .addFormDataPart("long", longitude)
                .build();

        Request request = new Request.Builder()
                //.url("http://192.168.0.132:8000/api/shipper/getDirection")
                .url("https://luxexpress.cf/api/ordertrakings/insertPosition")
                .post(requestBody)
                .addHeader("Authorization", "Bearer " + token)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                e.printStackTrace();
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                final String yourResponse = response.body().string();

                if (response.isSuccessful()) {


                    JSONObject Jobject = null;
                    try {

                        Jobject = new JSONObject(yourResponse);

                        //JSONArray Jarray = Jobject.getJSONArray("routes");
//                        List<MapsActivity.Route> List_lat_long = new ArrayList<MapsActivity.Route>();
//                        List_lat_long = parseJSon(yourResponse);
//                        showDirection(List_lat_long);
//                        Log.w("test map", List_lat_long.toString());

                    } catch (JSONException e) {
                        e.printStackTrace();
                    }


                } else {
                    Log.w("test map", yourResponse.toString());
                }


            }
        });

    }
}
