package com.example.quocchi.shipper_app;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.CertificatePinner;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class Fragment_Profile_Info extends Fragment {
    private View mRootView;

    private EditText full_name, id_number, date_of_birth, license_plates;
    private Spinner spinner_gender;
    private Button btn_done;


    private String hostname = "luxexpress.cf";
    String token = Login_Token.token;

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        mRootView = inflater.inflate(R.layout.fragment_profile_info, container, false);

        initUI();

        sendpost();

        return mRootView;
    }

    private void initUI(){

        full_name =(EditText) mRootView.findViewById(R.id.full_name);
        id_number =(EditText) mRootView.findViewById(R.id.id_number);
        date_of_birth =(EditText) mRootView.findViewById(R.id.date_of_birth);
        license_plates =(EditText) mRootView.findViewById(R.id.license_plates);
        spinner_gender =(Spinner) mRootView.findViewById(R.id.spinner_gender);

        btn_done = (Button)  mRootView.findViewById(R.id.btn_done);

        List<String> list_gen = new ArrayList<>();
        list_gen.add("Nam");
        list_gen.add("Nữ");

        ArrayAdapter<String> adapter_gen = new ArrayAdapter(getActivity(), android.R.layout.simple_spinner_item, list_gen);
        adapter_gen.setDropDownViewResource(android.R.layout.simple_list_item_single_choice);

        spinner_gender.setAdapter(adapter_gen);


        CertificatePinner certificatePinner = new CertificatePinner.Builder()
                .add(hostname, "sha256/MPTkwqvsxxFu44jSBUkloPwzP8VQwYEaGybVkEmRuww=")
                .add(hostname, "sha256/YLh1dUR9y6Kja30RrAn7JKnbQG/uEtLMkBgFF2Fuihg=")
                .add(hostname, "sha256/Vjs8r4z+80wjNcr1YKepWQboSIRi63WsWXhIMN+eWys=")
                .build();

        OkHttpClient client = new OkHttpClient.Builder()
                .certificatePinner(certificatePinner)
                .build();

        RequestBody requestBody = new MultipartBody.Builder()
                .setType(MultipartBody.FORM)
                .addFormDataPart("your_name_input", "your_value")
                .build();

        Request request = new Request.Builder()
                .url("https://luxexpress.cf/api/shipper/showProfileShipper")
                //.url(" http://192.168.0.132:8000/api/shipper/showOrder")
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
                    if (getActivity() != null) {
                        getActivity().runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                //Toast.makeText(getActivity(),"any mesage",Toast.LENGTH_LONG).show();
                                JSONObject Jobject = null;
                                try {
                                    //ListView lv = findViewById(R.id.list_view);
                                    Jobject = new JSONObject(yourResponse);

                                    JSONArray Jarray = Jobject.getJSONArray("data");
                                    JSONArray Jarray1 = Jobject.getJSONArray("data1");

                                    JSONObject object = Jarray.getJSONObject(0);
                                    JSONObject object1 = Jarray1.getJSONObject(0);
                                    //full_name, id_number, date_of_birth, license_plates
                                    license_plates.setText(object.getString("licensePlates"));
                                    id_number.setText(object1.getString("idNumber"));
                                    date_of_birth.setText(object1.getString("dateOfBirth"));
                                    full_name.setText(object1.getString("fullName"));

                                    int gen = 0;

                                    switch (object1.getString("gender")) {

                                        case "Nam":
                                            gen = 0;
                                            break;
                                        case "Nữ":
                                            gen = 1;
                                            break;
                                    }
                                    Log.w("showprofile", String.valueOf(gen));
                                    spinner_gender.setSelection(gen);
                                    Log.w("showprofile", yourResponse.toString());


                                } catch (JSONException e) {
                                    Log.w("showprofile error", yourResponse.toString());
                                    e.printStackTrace();
                                }

                            }

                        });
                    }
                } else {

                    Log.w("error showprofile", yourResponse.toString());
                }


            }
        });

        btn_done.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                CertificatePinner certificatePinner = new CertificatePinner.Builder()
                        .add(hostname, "sha256/MPTkwqvsxxFu44jSBUkloPwzP8VQwYEaGybVkEmRuww=")
                        .add(hostname, "sha256/YLh1dUR9y6Kja30RrAn7JKnbQG/uEtLMkBgFF2Fuihg=")
                        .add(hostname, "sha256/Vjs8r4z+80wjNcr1YKepWQboSIRi63WsWXhIMN+eWys=")
                        .build();

                OkHttpClient client = new OkHttpClient.Builder()
                        .certificatePinner(certificatePinner)
                        .build();
                //full_name, id_number, date_of_birth, license_plates
                RequestBody requestBody = new MultipartBody.Builder()
                        .setType(MultipartBody.FORM)
                        .addFormDataPart("license_plates", license_plates.getText().toString())
                        .addFormDataPart("date_of_Birth", date_of_birth.getText().toString())
                        .addFormDataPart("id_number", id_number.getText().toString())
                        .addFormDataPart("full_name", full_name.getText().toString())
                        .addFormDataPart("gender", spinner_gender.getSelectedItem().toString())
                        .build();

                Request request = new Request.Builder()
                        .url("https://luxexpress.cf/api/shipper/updateProfileShipper")
                        //.url(" http://192.168.0.132:8000/api/shipper/showOrder")
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
                            if (getActivity() != null) {
                                getActivity().runOnUiThread(new Runnable() {
                                    @Override
                                    public void run() {
                                        //Toast.makeText(getActivity(),"any mesage",Toast.LENGTH_LONG).show();
                                        JSONObject Jobject = null;
                                        try {
                                            //ListView lv = findViewById(R.id.list_view);
                                            Jobject = new JSONObject(yourResponse);

                                            //JSONArray Jarray = Jobject.getJSONArray("data");

                                            Toast.makeText(getActivity(),"Cập nhật thành công.",Toast.LENGTH_LONG).show();
                                            Log.w("sendprofile", yourResponse.toString());

                                        } catch (JSONException e) {
                                            Log.w("sendprofile error", yourResponse.toString());
                                            e.printStackTrace();
                                        }

                                    }

                                });
                            }
                        } else {

                            Log.w("error sendprofile", yourResponse.toString());
                        }


                    }
                });
            }
        });
    }

    private void sendpost(){

    }

}
