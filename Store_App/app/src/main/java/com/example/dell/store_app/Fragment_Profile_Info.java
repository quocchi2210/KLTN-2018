package com.example.dell.store_app;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.CertificatePinner;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class Fragment_Profile_Info extends Fragment{
    private View mRootView;

    private EditText name_store, type_store, address_store, des_store;

    private Button btn_done;


    private String hostname = "luxexpress.cf";
    String token = Login_Token.token;

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        mRootView = inflater.inflate(R.layout.fragment_profile_info, container, false);

       // initUI();

        //sendpost();

        return mRootView;
    }

    private void initUI() {
        // name_store, type_store, address_store, des_store
        name_store = (EditText) mRootView.findViewById(R.id.name_store);
        type_store = (EditText) mRootView.findViewById(R.id.type_store);
        address_store = (EditText) mRootView.findViewById(R.id.address_store);
        des_store = (EditText) mRootView.findViewById(R.id.des_store);

        btn_done = (Button) mRootView.findViewById(R.id.btn_done);

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
                .url("https://luxexpress.cf/api/store/showProfileStore")
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

                                    // name_store, type_store, address_store, des_store
                                    JSONObject object = Jarray.getJSONObject(0);

                                    //full_name, id_number, date_of_birth, license_plates
                                    name_store.setText(object.getString("object"));
                                    type_store.setText(object.getString("typeStore"));
                                    address_store.setText(object.getString("addressStore"));
                                    des_store.setText(object.getString("descriptionStore"));

                                } catch (JSONException e) {
                                    e.printStackTrace();
                                }

                            }

                        });
                    }
                } else {

                    Log.w("error order", yourResponse.toString());
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
                //name_store, type_store, address_store, des_store
                RequestBody requestBody = new MultipartBody.Builder()
                        .setType(MultipartBody.FORM)
                        .addFormDataPart("name_store", name_store.getText().toString())
                        .addFormDataPart("type_store", type_store.getText().toString())
                        .addFormDataPart("address_store", address_store.getText().toString())
                        .addFormDataPart("description_store", des_store.getText().toString())
                        .build();

                Request request = new Request.Builder()
                        .url("https://luxexpress.cf/api/store/updateProfileStore")
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




                                        } catch (JSONException e) {
                                            e.printStackTrace();
                                        }

                                    }

                                });
                            }
                        } else {

                            Log.w("error order", yourResponse.toString());
                        }


                    }
                });
            }
        });

    }

}
